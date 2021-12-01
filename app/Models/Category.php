<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'categories';
    protected $fillable = [
        'name', 'paren_id'
    ];
    public function  product()
    {
        return  $this->hasMany(Product::class, 'product_id', 'id');
    }
}