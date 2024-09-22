<?php

namespace App\Http\Controllers\Customer;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('query');
        
        $products = Product::where('name', 'LIKE', "%{$search}%")
                            ->get();

        return response()->json($products);
    }

    public function search_all_products(Request $request)
    {
        $text = $request->input('text');
        $categories = Category::where('active', 1)
            ->where('parent_id', 0)
            ->orderByDesc('id')
            ->get();

        $products = Product::where('active', 1)
            ->where('name', 'LIKE', '%' . $text . '%')
            ->paginate(9) -> appends(['text' => $text]);

        $message = '';
        if ($products->isEmpty()) {
            $message = 'Từ khóa "' . $text . '" không trùng khớp với sản phẩm nào!';
        }

        return view('customer.search', [
            'text' => $text,
            'products' => $products,
            'message' => $message,
            'title' => 'Kết quả tìm kiếm với từ khóa: ' . $text,
            'categories' => $categories
        ]);
    }


}
