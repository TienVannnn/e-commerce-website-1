<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Slider::class);
        $title = 'Danh sách sliders';
        $sliders = Slider::orderByDesc('id') -> paginate(10);
        return view('admin.slider.index', compact('title', 'sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Slider::class);
        $title = 'Thêm mới slider';
        return view('admin.slider.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $request -> validate([
                'name' => 'required|unique:sliders,name|max:100|min:5',
                'slug' => 'required|unique:sliders,slug|max:100|min:5',
                'image' => 'required|image|mimes:png,jpg,jepg,svg',
                'description' => 'required',
            ]);
            $get_image = $request -> image;
            $get_name_image = $get_image -> getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $path = './uploads/sliders/';
            $new_image = $name_image . rand(0, 999) . '.' . $get_image -> getClientOriginalExtension();
            Slider::create([
                'name' => $request -> name,
                'slug' => $request -> slug,
                'description' => $request -> description,
                'image' => $new_image,
                'active' => $request -> active
            ]); 
            DB::commit();
            $get_image -> move($path, $new_image);
            Session::flash('success', 'Thêm mới slider thành công');
        }
        catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', 'Thêm slider thất bại: ' . $e -> getMessage());
        }
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
        $slider = Slider::find($id);
        Gate::authorize('update', $slider);
        if(!$slider){
            Session::flash('error', 'Slider không tồn tại');
            return redirect() -> back();
        }
        $title = 'Cập nhật sản phẩm ' . $slider -> name;
        return view('admin.slider.edit', compact('title', 'slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            DB::beginTransaction();
            $request -> validate([
                'name' => 'required|max:100|min:5|unique:sliders,name,' . $id . ',id',
                'slug' => 'required|max:100|min:5|unique:sliders,slug,' . $id . ',id',
                'description' => 'required',
            ]);
            $slider = Slider::find($id);
            if(!$slider){
                Session::flash('error', 'Slider không tồn tại');
                return redirect() -> back();
            }
            $slider -> name = $request -> name;
            $slider -> slug = $request -> slug;
            $slider -> description = $request -> description;
            $slider -> active = $request -> active;

            if($request -> hasFile('image')){
                $old_image = $slider -> image;
                $get_image = $request -> image;
                $get_name_image = $get_image -> getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $path = './uploads/sliders/';
                $new_image = $name_image . rand(0, 999) . '.' . $get_image -> getClientOriginalExtension();
                $get_image -> move($path, $new_image);
                if($old_image && file_exists(public_path($path . $old_image))){
                    unlink(public_path($path . $old_image));
                }
                $slider -> image = $new_image;
            }
            DB::commit();
            $slider -> save();
            Session::flash('success', 'Cập nhật slider thành công');
        }
        catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', 'Cập nhật slider thất bại: ' . $e -> getMessage());
        }
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $slider = Slider::find($id);
            Gate::authorize('delete', $slider);
            if(!$slider){
                Session::flash('error', 'Slider không tồn tại');
                return redirect() -> back();
            }
            $path = './uploads/sliders/';
            $path_img = $path . $slider -> image;
            if($slider -> image && file_exists(public_path($path_img))){
                unlink(public_path($path_img));
            }
            $slider -> delete();
            Session::flash('success', 'Xóa slider thành công');
        }
        catch(\Exception $e){
            Session::flash('error', 'Xóa slider thất bại: ' . $e -> getMessage());
        }
        return redirect() -> back();
    }
}
