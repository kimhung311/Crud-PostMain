<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
    public function facebook(Request $request)
    {
        $facebook = $request->only('access_token');
        if (!$facebook || !isset($facebook['access_token'])) {
            return $this->responseErrors(config('code.user.login_facebook_failed'), trans('messages.user.login_facebook_failed'));
        }
        // Khởi tạo instance của Facebook Graph SDK
        $fb = new Facebook([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
        ]);

        try {
            $response = $fb->get('/me?fields=id,name,email,link,birthday', $facebook['access_token']); // Lấy thông tin 
            // user facebook sử dụng access_token được gửi lên từ client
            $profile = $response->getGraphUser();
            if (!$profile || !isset($profile['id'])) { // Nếu access_token không lấy đc thông tin hợp lệ thì trả về login false luôn
                return $this->responseErrors(config('code.user.login_facebook_failed'), trans('messages.user.login_facebook_failed'));
            }

            $email = $profile['email'] ?? null;
            $social = SocialNetwork::where('social_id', $profile['id'])->where('type', config('user.social_network.type.facebook'))->first();
            // Lấy được userId của Facebook ta kiểm tra trong bảng social_networks đã có chưa, nếu có thì tài khoản facebook này 
            // đã từng đăng nhập vào hệ thống ta chỉ cần lấy ra user rồi generate jwt trả về cho client; Ngược lại nếu chưa có thì 
            // ta sẽ tiếp tục dùng email trả về từ facebook kiểm tra xem nếu có user với email như thế rồi thì lấy luôn user đó nếu 
            // không thì tạo user mới với email trên và tạo bản ghi social_network lưu thông tin userId của facebook rồi generate jwt
            // để trả về cho client
            if ($social) {
                $user = $social->user;
            } else {
                $user = $email ? User::firstOrCreate(['email' => $email]) : User::create();
                $user->socialNetwork()->create([
                    'social_id' => $profile['id'],
                    'type' => config('user.social_network.type.facebook'),
                ]);
                $user->name = $profile['name'];
                $user->save();
            }

            $token = JWTAuth::fromUser($user);

            return $this->responseSuccess(compact('token', 'user'));
        } catch (\Exception $e) {
            Log::error('Error when login with facebook: ' . $e->getMessage());
            return $this->responseErrors(config('code.user.login_facebook_failed'), trans('messages.user.login_facebook_failed'));
        }
    }
}