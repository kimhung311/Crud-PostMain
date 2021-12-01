<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'name','image','status','description','price','quantity','category_id',
    ];

    public function category(){
      return   $this->belongsTo(Category::class,'category_id','id');
    }

}