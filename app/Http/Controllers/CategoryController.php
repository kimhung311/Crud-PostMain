<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStore;
use App\Http\Requests\UpdateCategory;
use App\Models\Category;
use Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $categories = Cache::rememberForever('categories', function () {
        //     return DB::table('categories')->get();
        // Cache::flush();
        $data = [];
        $categories = Category::paginate(5);
        $data['categories'] =  $categories;
      
        return view('category.index', $data)->with('success', 'List Categories into data to Category Sucessful');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('Category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)  //CategoryStore
    {

        //  $this->validate($request, $pattern, $messenger);
        //     $this->validate($request, ///  biến tham chiếu
        // [  
        //         'name'     => 'required|min:20|max:255',
        //         'paren_id' => 'required'
        //     ], //mảng định nghĩ dữ liệu

        //     [ // thông báo messenger
        //         'required' => 'tên trường Không được để trống',
        //         'min'      => 'tên trường không được nhỏ hơn :min',
        //         'max'      => 'teen trường không được lớn hơn :max',
        //         'integer'  => 'giá trị nhập vào phải là số ',
        //     ],

        //     [
        //         'name'     => 'Tên danh mục',
        //         'paren_id' => 'Danh mục con',
        //     ]/mảng tên các trường
        // );


      
        // if (!$request->hasFile('thumbnail')) {
        //     //Nếu chưa có file upload thì báo lỗi
        //     return 'Hãy chọn file để upload';
        // } else {
        //     //Xử lý file upload
        //     $image = $request->file('thumbnail');
        //     //Lưu trữ file tại public/images
        //     $imagePath = $image->move('storage/images', $image->getClientOriginalName());
        //     return 'Lưu trữ file thành công';
        // }
        $filename = $request->file('thumbnail')->hashName();
        $path = Storage::putFileAs('public/thumbnail', $request->file('thumbnail'), $filename);
        // return $path;

        $categoryInsert = [
            'name' => $request->category_name,
            'thumbnail' => $filename,
            'paren_id' => $request->paren_id,

        ];

        DB::beginTransaction();

        try {
            Category::create($categoryInsert);
        

            // insert into data to table category (successful)
            DB::commit();
            return redirect()->route('category.index')->withFlashSuccess('Insert into data category success');
        } catch (Exception $ex) {
            // insert into data to table category (fail)
            DB::rollBack();
            Log::error($ex->getMessage());
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        $category = Category::findOrFail($id);
        $data['category'] = $category;
        return view('Category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $request, $id)
    {
        DB::beginTransaction();
        try {
            // create $category
            $category = Category::find($id);
            $thumbnailOld = $category->thumbnail;

            // set value for field name
            $category->name = $request->category_name;

            if (
                $request->hasFile('thumbnail')
                && $request->file('thumbnail')->isValid()
            ) {
                // Nếu có thì thục hiện lưu trữ file vào public/thumbnail
                $image = $request->file('thumbnail');
                $extension = $request->thumbnail->extension();
                $fileName = 'thumbnail_' . time() . '.' . $extension;
                $thumbnailPath = $image->move('thumbnail', $fileName);
                $category->thumbnail = $thumbnailPath;
                Log::info('thumbnailPath: ' . $thumbnailPath);

                //  SAVE OK then delete OLD file
                if (File::exists(public_path($thumbnailOld))) {
                    File::delete(public_path($thumbnailOld));
                }
            }
            $category->save();

            DB::commit();
            return redirect()->route('category.index')->withFlashSuccess('edit successfully!');
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            return redirect()->back()->withFlashSuccess('edit error data!', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $category = Category::find($id);
            $category->delete();
            DB::commit();
            return redirect()->route('category.index')
                ->withFlashSuccess('Delete Category successful!');
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            return redirect()->back()->withFlashSuccess('Delete Category error data!', $ex->getMessage());
        }
    }

    public function checkHelper(){
        return  getMyText("Kim Hùng");
        // $value = getMyText();
        // $arrayValue= makeArray($value);
        // return $arrayValue;
    }
    public function test()
    {
        $image = Storage::url('app/thumbnail/Bwz9IGSHCNo5E7iGggtjoMBgOdU6AWgPYoykXBJX.jpg');
        dd($image);
        // return view('test', compact('image'));
        
    }
}