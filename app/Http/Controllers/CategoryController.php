<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStore;
use App\Http\Requests\UpdateCategory;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
    public function store(CategoryStore $request)
    {
        $categoryInsert = [
            'name' => $request->name,
            'paren_id' => $request->paren_id,
        ];
        DB::beginTransaction();
        try {
            // insert into data to table category (successful)
            Category::create($categoryInsert);
            // $cate = new Category();
            // $cate->name = 'hungcing';
            // $cate->paren_id = '1';
            // $cate->save();
            DB::commit();
            return redirect()->route('category.index')->withFlashSuccess('Insert into data category success');
        } catch (\Exception $ex) {
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
            $category  = Category::find($id);
            $category->name = $request->name;
            $category->paren_id = $request->paren_id;
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
}