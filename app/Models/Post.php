<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use HasFactory;

    use Notifiable;

    protected $table = 'post';
    protected $fillable = [
        'title', 'category_id', 'conntent', 'description', 'image','user_id'
    ];
    public function category()
    {
        return   $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return   $this->belongsTo(User::class, 'user_id', 'id');
    }
}