<?php

namespace App\Http\Controllers\Admin;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Config::class);
        $title = 'Danh sách config';
        $configs = Config::orderByDesc('id') -> paginate(5);
        return view('admin.config.index', compact('title', 'configs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Config::class);
        $title = 'Thêm mới config';
        return view('admin.config.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request -> validate([
                'key' => 'required|unique:configs,key',
                'value' => 'required|unique:configs,value',
            ]);
            Config::create($request -> all());
            Session::flash('success', 'Thêm mới config thành công');
        }
        catch(\Exception $e){
            Session::flash('error', 'Thêm mới config thất bại');
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
        $config = Config::find($id);
        Gate::authorize('update', $config);
        if(!$config){
            Session::flash('error', 'Config không tồn tại');
            return redirect() -> back();
        }
        $title = 'Chỉnh sửa config ' . $config -> key;
        return view('admin.config.edit', compact('title', 'config'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $config =Config::find($id);
            if(!$config){
                Session::flash('error', 'Config không tồn tại');
                return redirect() -> back();
            }
            $request -> validate([
                'key' => 'required|unique:configs,key, . ' . $config -> id . ' . ,id',
                'value' => 'required|unique:configs,value, . ' . $config -> id . ' . ,id',
            ]);
            $config -> fill($request -> input());
            $config -> save();
            Session::flash('success', 'Cập nhật config ' . $config -> key . ' thành công');
        }
        catch(\Exception $e){
            Session::flash('error', 'Cập nhật config ' . $config -> key . ' thất bại');
        }
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $config = Config::find($id);
        Gate::authorize('delete', $config);
        if(!$config){
            Session::flash('error', 'Config không tồn tại');
            return redirect() -> back();
        }
        $config -> delete();
        Session::flash('success', 'Xóa config ' . $config -> key . ' thành công');
        return redirect() -> back();
    }
}
