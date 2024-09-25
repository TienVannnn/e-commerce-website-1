<?php

namespace App\Http\Controllers\Customer;

use Log;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $slider;
    protected $cate;
    protected $product;
    public function __construct(Slider $slider, Category $c, Product $pr)
    {
        $this -> slider = $slider;
        $this -> cate = $c;
        $this -> product = $pr;
    }
    public function home(){
        $sliders = $this -> slider -> where('active', 1) -> orderByDesc('id') -> get();
        $categories = $this -> cate -> where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        $productFeatured = $this -> product -> where('active', 1) -> inRandomOrder() -> take(8) -> get();
        $recentProducts = $this -> product -> where('active', 1) -> orderByDesc('id') -> take(8) -> get();
        return view('customer.home', compact('sliders', 'categories', 'productFeatured', 'recentProducts'));
    }

    

    public function category($slug){
        $category = $this -> cate -> where('active', 1) -> where('slug', $slug) -> first();
        if(!$category){
            abort(404);
        }
        while ($category->parent) {
            $category = $category->parent;
        }
        $allCategoryIds = $category->allChildCategories()->get()->pluck('id')->toArray();
        $allCategoryIds[] = $category->id;
        $products = Product::whereIn('category_id', $allCategoryIds)-> paginate(6);

        $categories = $this -> cate -> where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        // $products = $this -> product -> where('active', 1) -> where('category_id', $category -> id) -> get();
        $title = $category -> name;
        return view('customer.category', compact('title', 'category', 'products', 'categories'));
    }

    public function category_child($slugParent, $slugChild){
        $categories = $this -> cate -> where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        $c_parent = $this -> cate -> where('active', 1) -> where('slug', $slugParent) -> first();
        $category = $this -> cate -> where('active', 1) -> where('slug', $slugChild) -> first();
        $title = $category -> name;
        $products = $this -> product -> where('category_id', $category -> id) -> orderByDesc('id') -> paginate(9);
        return view('customer.category', compact('title', 'categories', 'c_parent', 'category', 'products'));
    }

    
}
