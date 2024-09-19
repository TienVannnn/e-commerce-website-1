<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteProductController extends Controller
{
    public function addFavoriteProduct($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Bạn cần phải đăng nhập trước khi muốn thực hiện thêm sản phẩm yêu thích'
            ], 401); // 401 Unauthorized
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Sản phẩm không tồn tại'
            ], 404); // 404 Not Found
        }

        // Kiểm tra nếu sản phẩm đã có trong danh sách yêu thích của user
        $favoriteExists = FavoriteProduct::where('user_id', $user->id)
            ->where('product_id', $id)
            ->exists();

        if ($favoriteExists) {
            return response()->json([
                'message' => 'Sản phẩm đã có trong danh sách yêu thích'
            ], 409); // 409 Conflict
        }

        FavoriteProduct::create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        return response()->json([
            'title' => 'Thành công',
            'message' => 'Thêm sản phẩm yêu thích thành công',
            'status' => 200
        ], 200);
    }

}
