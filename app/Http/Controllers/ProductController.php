<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $value = Cache::remember('users', 1000, function () {
            return DB::table('users')->get();
        });



        // $value = Cache::rememberForever('users', function () { // truy xuất mục bộ nhớ cache lưu trữ vĩnh viễn
        //     return DB::table('users')->get();
        // });
        // Cache::add('cachekey2', 'number'); 
        // Cache::flush(); // xoá toàn bộ  bộ nhớ cache


        $value = Cache::pull('users'); //truy xuất bộ nhớ cache và xoá nó

        dd($value);
        // Cache::put('cachekey', 'this should bea cache key', now()->addDay()); // luư cache  trong 1 ngày
        // Cache::forever('cachekey2', 4); // thời gian sống vĩnh viễn
        // Cache::forget('cachekey2'); // xoas cache
        // if(Cache::has('cachekey2')){
        //     dd('cache does exists');
        // }
        // Cache::increment('cachekey2', 1); // tăng gtri
        // Cache::decrement('cachekey2', 1);// giảm gtri

        // $products = Cache::remember('users', 1000, function () {
        //     return DB::table('users')->get();
        // });

        // Cache::store('file')->put('users', ' lưu vào bộ nhớ', 200);
        // dd($products);
        // Cache::forget('users'); // xoas cache

        // dd( Cache::get('users'));

        // $collection = collect([
        //     ['name' => 'Desk', 'price' => 200],
        //     ['name' => 'Chair', 'price' => 100],
        //     ['name' => 'Bookcase', 'price' => 150],
        // ]);

        // $sorted = $collection->sortByDesc('price');

        // $sorted->values()->all();

        // $data = [];
        // $products = Product::all();
        // dd(Cache::flush('products'));
        // $data['products'] =  $products;

      
               
        return view('product.index', $value);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}