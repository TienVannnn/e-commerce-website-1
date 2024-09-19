<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    protected $p;
    protected $htmlSelected;
    public function __construct(Permission $pe)
    {
        $this -> p = $pe;
        $this -> htmlSelected = '';
    }

    public function index()
    {
        Gate::authorize('viewAny', Permission::class);
        $title = 'Danh sách quyền';
        $permissions = $this -> p -> orderByDesc('id') -> paginate(10);
        return view('admin.permission.index', compact('title', 'permissions'));
    }

    public function permissionRecusive($id, $text = '')
    {
        $data = $this -> p -> where('active', 1)->get();
        foreach ($data as $va) {
            if ($va->parent_id == $id) {
                $this->htmlSelected .= '<option value="' . $va->id . '">' . $text . $va->name . '</option>';
                $this->permissionRecusive($va->id, $text . '|-');
            }
        }
        return $this->htmlSelected;
    }

    public function permissionRecusiveEdit($id, $text = '', $idCategory)
    {
        $data = $this -> p -> where('active', 1) -> where('id', '!=', $idCategory -> id) ->get();
        foreach ($data as $va) {
            if ($va->parent_id == $id) {
                $selected = ($idCategory->parent_id == $va->id) ? 'selected' : '';
                $this->htmlSelected .= '<option value="' . $va->id . '" ' . $selected . '>' . $text . $va->name . '</option>';
                $this->permissionRecusiveEdit($va->id, $text . '|-', $idCategory);
            }
        }
        return $this->htmlSelected;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Permission::class);
        $title = 'Thêm mới quyền';
        $permissionParent = $this ->p -> where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        return view('admin.permission.create', compact('title', 'permissionParent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $request -> validate([
                'name' => 'required|unique:permissions,name',
                'keycode' => 'required|unique:permissions,keycode',
                'description' => 'required'
            ]);
            $this -> p -> create($request -> input());
            DB::commit();
            Session::flash('success', 'Thêm mới quyền thành công');
        }
        catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', 'Thêm mới quyền thất bại: ' . $e -> getMessage());
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
        $permission = $this -> p -> find($id);
        Gate::authorize('update', $permission);
        if(!$permission){
            abort(404);
        }
        $title = 'Chỉnh sửa quyền ' . $permission -> name;
        $htmlOptions = $this -> permissionRecusiveEdit(0, '', $permission);
        return view('admin.permission.edit', compact('title', 'permission', 'htmlOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            DB::beginTransaction();
            $permission = $this -> p -> find($id);
            if(!$permission){
                Session::flash('error', 'Quyền không tồn tại');
                return redirect() -> back();
            }
            $request -> validate([
                'name' => 'required|unique:permissions,name,' . $permission -> id . ',id',
                'description' => 'required',
                'keycode' => 'required|unique:permissions,keycode,' . $permission -> id . ',id'
            ]);
            $permission -> fill($request -> input());
            $permission -> save();
            DB::commit();
            Session::flash('success', 'Cập nhập quyền ' . $permission -> name . ' thành công');
        }
        catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', 'Cập nhật quyền lỗi: ' . $e -> getMessage());
        }
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = $this -> p -> find($id);
        Gate::authorize('delete', $permission);
        if(!$permission){
            Session::flash('error', 'Quyền không tồn tại');
            return redirect() -> back();
        }
        $permissionsChild = $this -> p -> where('parent_id', $permission -> id) -> get();
        if($permissionsChild){
            foreach($permissionsChild as $va){
                $va -> delete();
            }
        }
        $permission -> delete();
        Session::flash('success', 'Xóa quyền thành công');
        return redirect() -> back();
    }
}
