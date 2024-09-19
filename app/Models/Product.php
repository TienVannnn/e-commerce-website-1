<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'slug',
        'price',
        'code',
        'short_des',
        'image',
        'content',
        'quantity',
        'quantity_sold',
        'category_id',
        'active'
    ];
    public function category(){
        return $this -> hasOne(Category::class, 'id', 'category_id');
    }

    public function tags(){
        return $this -> belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function images_detail(){
        return $this -> hasMany(Product_Image::class, 'product_id', 'id');
    }
}
