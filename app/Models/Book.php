<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    //
    protected $fillable = [
        'title',
        'author_name',
        'price',
        'description',
        'quantity',
        'book_img',
        'author_img',
        'category_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
