<?php

namespace App\Http\Controllers\Customer;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('query');
        
        $products = Product::where('name', 'LIKE', "%{$search}%")
                            ->get();

        return response()->json($products);
    }

}
