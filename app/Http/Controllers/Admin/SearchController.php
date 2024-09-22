<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $text = $request -> text;
        $products = Product::where('name', 'like', '%'. $text .'%') -> paginate(10)->appends(['text' => $text]); ;
        $title = 'Kết quả tìm kiếm cho từ khóa: ' . $text;
        return view('admin.search.search', compact('title', 'text', 'products'));
    }
}
