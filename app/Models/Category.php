<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{

    use HasFactory;
    use Notifiable;

    protected $table = 'categories';
    protected $fillable = [
        'name', 'parent_id', 'thumbnail'
    ];
    public function  product()
    {
        return  $this->hasMany(Product::class, 'product_id', 'id');
    }

    public function  post()
    {
        return  $this->hasMany(Post::class, 'post_id', 'id');
    }
}