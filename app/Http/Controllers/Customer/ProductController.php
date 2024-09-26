<?php

namespace App\Http\Controllers\Customer;
use App\Models\Review;

use App\Models\Product;
use App\Models\Category;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    protected $cate;
    protected $product;
    protected $review;
    public function __construct(Category $c, Product $pr, Review $review)
    {
        $this -> cate = $c;
        $this -> product = $pr;
        $this -> review = $review;
    }

    public function productDetail($slug)
    {
        $categories = $this->cate->where('active', 1)->where('parent_id', 0)->orderByDesc('id')->get();
        $product = $this->product->where('active', 1)->where('slug', $slug)->first();
        if (!$product) {
            abort(404);
        }
        $reviews = $this -> review -> where('product_id', $product -> id) -> get();
        $sum = $reviews->sum('rate'); 
        $count = $reviews->count(); 

        $avgRate = $count > 0 ? floor($sum / $count) : 5;
        $category = $this->cate->where('id', $product->category_id)->first();
        while ($category->parent) {
            $category = $category->parent;
        }
        $allCategoryIds = $category->allChildCategories()->get()->pluck('id')->toArray();
        $allCategoryIds[] = $category->id;
        $relativeProducts = Product::whereIn('category_id', $allCategoryIds)->where('id', '!=', $product->id)->get();
        $title = $product->name;
        return view('customer.product_detail', compact('title', 'product','reviews', 'categories', 'relativeProducts', 'avgRate'));
    }


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

    public function all_product(){
        $categories = Category::where('active', 1)
            ->where('parent_id', 0)
            ->orderByDesc('id')
            ->get();
        $title = 'Tất cả sản phẩm';
        $products = Product::where('active', 1) -> orderByDesc('id') -> paginate(15);
        return view('customer.product.all_product', compact('title', 'categories', 'products'));
    }

    // Xử lý không cần lưu vào bộ nhớ tam
    public function review(Request $request, $slug) {
        // dd($request -> images);
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login.customer.form');
        }
        $product = Product::where('active', 1)->where('slug', $slug)->first();
        if (!$product) {
            abort(404);
        }
        try {
            DB::beginTransaction();
            $review = Review::create([
                'rate' => $request->rate,
                'content' => $request->content,
                'user_id' => $user->id,
                'product_id' => $product->id,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
    
            if ($request->has('images')) {
                foreach ($request->images as $imageName) {
                    $finalPath = public_path('./uploads/customer/reviews/' . $imageName);
                    file_put_contents($finalPath, ''); 
                    ReviewImage::create([
                        'review_id' => $review->id,
                        'image' => $imageName
                    ]);
                }
            }
            DB::commit();
            Session::flash('success-review', 'Đánh giá của bạn đã được gửi!');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error-review', 'Đánh giá của bạn gửi thất bại! ' . $e->getMessage());
        }
        return redirect()->back();
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) { 
                $filename = time() . '_' . $file->getClientOriginalName();
            }
            return response()->json(['success' => true, 'filename' => $filename]); 
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    public function revert(Request $request)
    {
        $filename = $request->input('filename'); 
        if($filename){
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'File not found or is a directory'], 404); 
    }

    // xử lý lưu vào bộ nhớ tạm

    // public function review(Request $request, $slug) {
    //     // dd($request -> images);
    //     $user = Auth::user();
    //     if (!$user) {
    //         return redirect()->route('login.customer.form');
    //     }
    //     $product = Product::where('active', 1)->where('slug', $slug)->first();
    //     if (!$product) {
    //         abort(404);
    //     }
    //     try {
    //         DB::beginTransaction();
    //         $review = Review::create([
    //             'rate' => $request->rate,
    //             'content' => $request->content,
    //             'user_id' => $user->id,
    //             'product_id' => $product->id,
    //         ]);
    
    //         if ($request->has('images')) {
    //             foreach ($request->images as $imageName) {
    //                 $tempPath = './uploads/temp/' . $imageName;
    //                 $finalPath = './uploads/customer/reviews/';
    //                 if (file_exists(public_path($tempPath))) {
    //                     rename(public_path($tempPath), public_path($finalPath . $imageName));
    //                     ReviewImage::create([
    //                         'review_id' => $review->id,
    //                         'image' => $imageName
    //                     ]);
    //                 }
    //             }
    //         }
    //         DB::commit();
    //         Session::flash('success-review', 'Đánh giá của bạn đã được gửi!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Session::flash('error-review', 'Đánh giá của bạn gửi thất bại! ' . $e->getMessage());
    //     }
    //     return redirect()->back();
    // }
    
    // public function upload(Request $request)
    // {
    //     if ($request->hasFile('image')) {
    //         foreach ($request->file('image') as $file) { 
    //             $filename = time() . '_' . $file->getClientOriginalName();
    //             $tempPath = './uploads/temp/'; 
    //             $file->move(public_path($tempPath), $filename);
    //         }
    //         return response()->json(['success' => true, 'filename' => $filename]); 
    //     }
    //     return response()->json(['error' => 'No file uploaded'], 400);
    // }

    // public function revert(Request $request)
    // {
    //     $filename = $request->input('filename'); 
    //     $tempPath = public_path('./uploads/temp/' . $filename); 
    //     if (file_exists($tempPath) && !is_dir($tempPath)) {
    //         unlink($tempPath); 
    //         return response()->json(['success' => true]);
    //     }
    //     return response()->json(['error' => 'File not found or is a directory'], 404); 
    // }

    


    public function clearTempImages(Request $request)
    {
        if ($request->has('images')) {
            foreach ($request->images as $imageName) {
                $tempPath = './uploads/temp/' . $imageName;
                if (file_exists(public_path($tempPath))) {
                    unlink(public_path($tempPath)); 
                }
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'No images found'], 400);
    }

    

}
