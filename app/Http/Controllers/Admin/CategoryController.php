<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    protected $htmlSeleted;

    public function __construct()
    {
        $this -> htmlSeleted = '';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Category::class);
        $categories = Category:: paginate(9);
        $title = 'Danh sách danh mục';
        return view('admin.category.index') -> with(compact('categories', 'title'));
    }

    public function categoryRecusive($id, $text = '')
    {
        $data = Category::where('active', 1)->get();
        foreach ($data as $va) {
            if ($va->parent_id == $id) {
                $this->htmlSeleted .= '<option value="' . $va->id . '">' . $text . $va->name . '</option>';
                $this->categoryRecusive($va->id, $text . '|-');
            }
        }
        return $this->htmlSeleted;
    }

    public function categoryRecusiveEdit($id, $text = '', $idCategory)
    {
        $data = Category::where('active', 1) -> where('id', '!=', $idCategory -> id) ->get();
        foreach ($data as $va) {
            if ($va->parent_id == $id) {
                $selected = ($idCategory->parent_id == $va->id) ? 'selected' : '';
                $this->htmlSeleted .= '<option value="' . $va->id . '" ' . $selected . '>' . $text . $va->name . '</option>';
                $this->categoryRecusiveEdit($va->id, $text . '|-', $idCategory);
            }
        }
        return $this->htmlSeleted;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Category::class);
        $title = 'Add new category';
        $categories = Category::where('active', 1) -> orderByDesc('id') -> get();
        $htmlOptions = $this -> categoryRecusive(0);
        return view('admin.category.create') -> with(compact('title', 'categories', 'htmlOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required'
        ]);
        try{
            $c  = new Category();
            $c -> name = $request -> name;
            $c -> slug = $request -> slug;
            $c -> parent_id = $request -> parent_id;
            $c -> active = $request -> active;
            $c -> description = $request -> description;
            $get_image = $request -> img;
            $path = './uploads/category/';
            $get_name_image = $get_image -> getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0, 99).'.'.$get_image -> getClientOriginalExtension();
            $get_image -> move($path, $new_image);
            $c -> img = $new_image;
            $c -> save();
            Session::flash('success', 'Add category successfully');
        }
        catch(\Exception $err){
            Session::flash('error', 'Add category failed, err: ' . $err);
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
        $categories = Category::where('active', 1) -> orderByDesc('id') -> get();
        $category = Category::find($id);
        Gate::authorize('update', $category);
        if(!$category){
            Session::flash('error', 'Category không tồn tại');
            return redirect() -> back();
        }
        $htmlOptions = $this -> categoryRecusiveEdit(0, '', $category);
        $title = 'Chỉnh sửa danh mục ' . $category -> name;
        return view('admin.category.edit') -> with(compact('categories', 'category', 'title', 'htmlOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required'
        ]);
        try{
            $c = Category::find($id);
            if(!$c){
                Session::flash('error', 'Category không tồn tại');
                return redirect() -> back();
            }
            $c -> name = $request -> name;
            $c -> slug = $request -> slug;
            $c -> description = $request -> description;
            $c -> parent_id = $request -> parent_id;
            $c -> active = $request -> active;
    
            if($request -> hasFile('img')){
                $old_image = $c -> img;
                $get_image = $request -> img;
                $path = 'uploads/category/';
                $get_name_image = $get_image -> getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image.rand(0, 99).'.'. $get_image -> getClientOriginalExtension();
                $get_image -> move($path, $new_image);
                
                if($old_image && file_exists(public_path($path . $old_image))){
                    unlink(public_path($path . $old_image));
                }

                $c -> img = $new_image;
            }
            $c -> save();
            Session::flash('success', 'Update category successfully');
        }
        catch(\Exception $err){
            Session::flash('error', 'Update Category failed. err: '. $err -> getMessage());
        }
        return redirect() -> back();
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::find($id);
            Gate::authorize('delete', $category);
            if(!$category){
                Session::flash('error', 'Category không tồn tại');
                return redirect() -> back();
            }
            $path = './uploads/category/' . $category -> img;
            if(file_exists($path)){
                unlink($path);
            }
            $category -> delete();
            Session::flash('success', 'Deleted Category Successfully');
        }
        catch(\Exception $err){
            Session::flash('error', 'Deleted Category Failed');
        }
        return redirect() -> back();
    }
}
