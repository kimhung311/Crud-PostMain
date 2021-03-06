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
        // Kh???i t???o instance c???a Facebook Graph SDK
        $fb = new Facebook([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
        ]);

        try {
            $response = $fb->get('/me?fields=id,name,email,link,birthday', $facebook['access_token']); // L???y th??ng tin 
            // user facebook s??? d???ng access_token ???????c g???i l??n t??? client
            $profile = $response->getGraphUser();
            if (!$profile || !isset($profile['id'])) { // N???u access_token kh??ng l???y ??c th??ng tin h???p l??? th?? tr??? v??? login false lu??n
                return $this->responseErrors(config('code.user.login_facebook_failed'), trans('messages.user.login_facebook_failed'));
            }

            $email = $profile['email'] ?? null;
            $social = SocialNetwork::where('social_id', $profile['id'])->where('type', config('user.social_network.type.facebook'))->first();
            // L???y ???????c userId c???a Facebook ta ki???m tra trong b???ng social_networks ???? c?? ch??a, n???u c?? th?? t??i kho???n facebook n??y 
            // ???? t???ng ????ng nh???p v??o h??? th???ng ta ch??? c???n l???y ra user r???i generate jwt tr??? v??? cho client; Ng?????c l???i n???u ch??a c?? th?? 
            // ta s??? ti???p t???c d??ng email tr??? v??? t??? facebook ki???m tra xem n???u c?? user v???i email nh?? th??? r???i th?? l???y lu??n user ???? n???u 
            // kh??ng th?? t???o user m???i v???i email tr??n v?? t???o b???n ghi social_network l??u th??ng tin userId c???a facebook r???i generate jwt
            // ????? tr??? v??? cho client
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