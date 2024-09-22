<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilterProductController extends Controller
{
    public function filterProducts(Request $request) {
        $query = Product::query();
        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
            $category = Category::find($categoryId);
            if ($category) {
                $allCategoryIds = $category->allChildCategories()->pluck('id')->toArray();
                $allCategoryIds[] = $category->id; 
                $query->whereIn('category_id', $allCategoryIds);
            }
        }
        if ($request->has('price_range')) {
            $priceRanges = $request->input('price_range');
            $query->where(function ($q) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    if (strpos($range, '-') !== false) {
                        [$min, $max] = explode('-', $range);
                        $q->orWhereBetween('price', [(int)$min, (int)$max]);
                    }
                }
            });
        }

        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'Oldest':
                    $query->orderBy('id', 'asc');
                    break;
                case 'Lastest':
                    $query->orderBy('id', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        }

        $limit = $request->input('limit', 9);
    
        $products = $query->paginate($limit);
    
        return response()->json([
            'message' => 'Lọc sản phẩm thành công',
            'products' => $products
        ]);
    }
    
}
