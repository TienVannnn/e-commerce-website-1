<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product_Image;
use App\Service\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    protected $product;
    public function __construct(ProductService $productService)
    {
        $this -> product = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Product::class);
        $title = 'Danh sách sản phẩm';
        $products = Product::orderByDesc('id') ->with('category') -> paginate(10);
        return view('admin.product.index', compact('title', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Product::class);
        $title = 'Add new product';
        $category = Category::where('active', 1) -> orderByDesc('id') -> get();
        return view('admin.product.create', compact('title', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $request -> validated();
        $this -> product -> createProduct($request);
        return redirect() -> back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Gate::authorize('edit', Product::class);
        $product = Product::find($id);
        Gate::authorize('update', $product);
        if(!$product){
            Session::flash('error', 'Product không tồn tại');
            return redirect() -> back();
        }
        $title = 'Edit product ' . $product -> name;
        $category = Category::where('active', 1) -> orderByDesc('id') -> get();
        return view('admin.product.edit', compact('title', 'product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $request -> validated();
        $this -> product -> updateProduct($request, $id);
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        Gate::authorize('delete', $product);
        if(!$product){
            Session::flash('error', 'Product không tồn tại');
            return redirect() -> back();
        }
        $this -> product -> deleteProduct($product);
        return redirect() -> back();
    }
}
