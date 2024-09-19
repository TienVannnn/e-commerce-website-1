<?php

namespace App\Models;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'active',
        'img'
    ];
    public function products(){
        return $this -> hasMany(Product::class, 'category_id', 'id');
    }

    public function parent(){
        return $this -> belongsTo(Category::class, 'parent_id');
    }
    
    public function child(){
        return $this -> hasMany(Category::class, 'parent_id');
    }

    public function allChildCategories()
    {
        return $this->child()->with('allChildCategories');
    }

    public function totalProducts()
    {
        $allCategories = $this->child()->with('allChildCategories')->get()->pluck('id')->toArray();
        $allCategories[] = $this->id;
        return Product::whereIn('category_id', $allCategories)->count();
    }
}
