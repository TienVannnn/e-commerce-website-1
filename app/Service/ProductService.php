<?php

namespace App\Service;
    use App\Models\Product;
    use App\Models\Product_Image;
    use App\Models\ProductTag;
    use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

    class ProductService{
        public function createProduct($request){
            try{
                DB::beginTransaction();
                $product = new Product();
                $product -> code  = $request -> code;
                $product -> name  = $request -> name;
                $product -> slug  = $request -> slug;
                $product -> price  = $request -> price;
                if($request -> quantity){
                    $product -> quantity  = $request -> quantity;
                }
                $product -> category_id  = $request -> category_id;
                $product -> short_des  = $request -> short_des;
                $product -> content  = $request -> content;
                $product -> active  = $request -> active;
        
                $get_image = $request -> image;
                $path = './uploads/products/';
                $get_name_image = $get_image -> getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0,99). '.' . $get_image -> getClientOriginalExtension();
                $get_image -> move($path, $new_image);
                $product -> image = $new_image;
                $product -> save();

                if($request -> hasFile('image_detail')){
                    foreach ($request->file('image_detail') as $imageDetail) {
                        $get_name_image_detail = $imageDetail->getClientOriginalName();
                        $pathDetail = './uploads/productDetails/';
                        $name_image_detail = current(explode('.', $get_name_image_detail));
                        $new_image_detail = $name_image_detail . rand(0, 99) . '.' . $imageDetail->getClientOriginalExtension();
                        $imageDetail->move($pathDetail, $new_image_detail);
                        Product_Image::create([
                            'image_detail' => $new_image_detail,
                            'product_id' => $product -> id
                        ]);
                    }
                }

                if($request -> tags){
                    foreach($request -> tags  as $tag){
                        $tagInstance = Tag::firstOrCreate([
                            'name' => $tag
                        ]);
                        ProductTag::create([
                            'product_id' => $product -> id,
                            'tag_id' => $tagInstance -> id
                        ]);
                    }
                }
                DB::commit();
                Session::flash('success', 'Thêm sản phẩm thành công');
                return true;
            }
            catch(\Exception $e){
                DB::rollBack();
                Session::flash('error', 'Thêm sản phẩm lỗi: ' . $e -> getMessage());
                return false;
            }
        }

        public function updateProduct($request, $id){
            try{
                $filesToDelete = [];
                DB::beginTransaction();
                $product = Product::find($id);
                if(!$product){
                    Session::flash('error', 'Product không tồn tại');
                    return false;
                }
                $product -> code  = $request -> code;
                $product -> name  = $request -> name;
                $product -> slug  = $request -> slug;
                $product -> price  = $request -> price;
                if($request -> quantity){
                    $product -> quantity  = $request -> quantity;
                }
                $product -> category_id  = $request -> category_id;
                $product -> short_des  = $request -> short_des;
                $product -> content  = $request -> content;
                $product -> active  = $request -> active;

                if($request -> hasFile('image')){
                    $old_image = $product -> image;
                    $get_image = $request -> image;
                    $get_name_image = $get_image -> getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $path = './uploads/products/';
                    $new_image = $name_image . rand(0,999) . '.' . $get_image -> getClientOriginalExtension();
                    $get_image -> move($path, $new_image);
                    if($old_image && file_exists(public_path($path . $old_image))){
                        $filesToDelete[] = (public_path($path . $old_image));
                    }
                    $product -> image = $new_image;
                }

                $product -> save();

                if($request -> hasFile('image_detail')){

                    Product_Image::where('product_id', $product->id)->each(function ($image) {
                        $pathDetail = './uploads/productDetails/';
                        if ($image->image_detail && file_exists(public_path($pathDetail . $image->image_detail))) {
                            $filesToDelete[] = (public_path($pathDetail . $image->image_detail));
                        }
                        $image->delete();
                    });

                    foreach($request -> file('image_detail') as $image_item){
                        $get_image_detail = $image_item;
                        $get_name_image_detail = $get_image_detail -> getClientOriginalName();
                        $name_image_detail = current(explode('.', $get_name_image_detail));
                        $path_detail = './uploads/productDetails/';
                        $new_image_detail = $name_image_detail . rand(0,999) . '.' . $get_image_detail -> getClientOriginalExtension();
                        $get_image_detail -> move($path_detail, $new_image_detail);
                        Product_Image::create([
                            'product_id' => $product -> id,
                            'image_detail' => $new_image_detail
                        ]);
                    }
                }

                if($request->tags){
                    ProductTag::where('product_id', $product->id)->delete();
                    foreach($request->tags as $tag){
                        $newTag = Tag::firstOrCreate(['name' => $tag]);
                        ProductTag::create([
                            'product_id' => $product->id,
                            'tag_id' => $newTag->id
                        ]);
                    }
                }
                DB::commit();
                foreach($filesToDelete as $file){
                    if(file_exists($file)){
                        unlink($file);
                    }
                }
                Session::flash('success', 'Update sản phẩm thành công');
                return true;    
            }
            catch(\Exception $e){
                DB::rollBack();
                Session::flash('error', 'Update sản phẩm lỗi: '. $e -> getMessage());
                return false;
            }
        }

    public function deleteProduct($product)
        {
            try {
                DB::beginTransaction();
                $filesToDelete = [];
                $path = './uploads/products/';
                if ($product->image && file_exists(public_path($path . $product->image))) {
                    $filesToDelete[] = public_path($path . $product->image);
                }
        
                $productDetails = Product_Image::where('product_id', $product->id)->get();
                if ($productDetails) {
                    $path_detail = './uploads/productDetails/';
                    foreach ($productDetails as $item) {
                        if ($item->image_detail && file_exists(public_path($path_detail . $item->image_detail))) {
                            $filesToDelete[] = public_path($path_detail . $item->image_detail);
                        }
                    }
                }
        
                $name = $product->name;
                $product->delete();
        
                DB::commit();
                foreach ($filesToDelete as $file) {
                    unlink($file);
                }
                Session::flash('success', 'Xóa sản phẩm ' . $name . ' thành công');
                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                Session::flash('error', 'Xóa sản phẩm lỗi');
                return false;
            }
    }
}