<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Collection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ColllertionController extends Controller
{
    private $users;
    
    public function __construct(){
        $json = Http::get( 'https://www.reddit.com/r/MechanicalKeyboards.json');
        // $this->products = collect($json['data']);
    }

    public function getUsers()
    {
        $users = User::all();
        dd($users);
    }

    public function first()
    {
        $user = User::first();   //phương thức trả về giá trị đầu tiên 
        dd($user->name); //để lấy tên của người dùng đầu tiên 
    }

    public function where()
    {
        $users = User::all();
        $user = $users->where('id', 2);  // tiềm kiếm theo  cặp từ khoá hoặc giá trị nhất định
        //Collection of user with an ID of 2

        $user = $users->where('id', 6)
            ->where('name', 'WDFXbttv');

            dd($user);
        //collection of user with an id of 1, age 51
        //and named Chasity Tillman
    }



    public function filter()  //phương pháp lọc bộ sưu tập bằng cách sử dụng gọi lại nhất định,
    {
        $users = User::all();
        $youngsters = $users->filter(function ($value, $key) {
            return $value->id < 6;
        });

        $youngsters->all();
        dd($youngsters);
        //list of all users that are below the age of 35
    }


    public function groupBy() // các trường giống nhau lại
    {
        $movies = collect([
            ['name' => 'Back To the Future', 'genre' => 'scifi', 'rating' => 8],
            ['name' => 'The Matrix',  'genre' => 'fantasy', 'rating' => 9],
            ['name' => 'The Croods',  'genre' => 'animation', 'rating' => 8],
            ['name' => 'Zootopia',  'genre' => 'animation', 'rating' => 4],
            ['name' => 'The Jungle Book',  'genre' => 'fantasy', 'rating' => 5],
        ]);

        $genre = $movies->groupBy('genre');
        dd($genre);
    
        $rating = $movies->groupBy(function ($movie, $key) {
            return $movie['rating'];
            
        });
        // dd($rating);
        
     
    }

    public function chunkMe()
    {
                                            
        $list = User::all();
        $chunks = $list->chunk(10); // chia dữ liệu ra làm các mảng  mỗi mảng sẽ có 10 giá trị

        $chunks->toArray();
        dd($chunks->toArray());
   
    }
}