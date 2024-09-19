<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    protected $r;
    protected $p;
    public function __construct(Role $role, Permission $pe)
    {
        $this -> r  = $role;
        $this -> p = $pe;
    }

    public function index()
    {
        Gate::authorize('viewAny', Role::class);
        $title = 'Danh sách vai trò';
        $roles = $this -> r -> orderByDesc('id') -> paginate(10);
        return view('admin.role.index', compact('title', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Role::class);
        $title = 'Thêm mới vai trò';
        $permissionParent = $this -> p -> where('parent_id', 0) -> where('active', 1) -> get();
        return view('admin.role.create', compact('title', 'permissionParent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $request -> validate([
                'name' => 'required|unique:roles,name',
                'description' => 'required'
            ]);
            $role = $this -> r -> create($request -> except('permission_id', 'add'));
            $role -> permissions() -> attach($request -> permission_id);
            DB::commit();
            Session::flash('success', 'Thêm mới vai trò thành công');
        }
        catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', 'Thêm mới vai trò thất bại: ' . $e -> getMessage());
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
        $role = $this -> r -> find($id);
        Gate::authorize('update', $role);
        if(!$role){
            Session::flash('error', 'Vai trò không tồn tại');
            return redirect() -> back();
        }
        $permissionParent = $this -> p -> where('parent_id' , 0) -> where('active', 1) -> get();
        $permissionChecked = $role -> permissions;
        $title = 'Chỉnh sửa vai trò ' . $role -> name;
        return view('admin.role.edit', compact('title', 'role', 'permissionParent', 'permissionChecked'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request -> permission_id);
        try{
            DB::beginTransaction();
            $role = $this -> r -> find($id);
            if(!$role){
                Session::flash('error', 'Vai trò không tồn tại');
                return redirect() -> back();
            }
            $request -> validate([
                'name' => 'required|unique:roles,name,' . $role -> id . ',id',
                'description' => 'required'
            ]);
            $role -> fill($request -> except('permission_id', 'update'));
            DB::commit();
            $role -> save();
            $role -> permissions() -> sync($request -> permission_id);
            Session::flash('success', 'Cập nhật vai trò thành công');
        }
        catch(\Exception $e){
            Session::flash('error', 'Cập nhật vai trò thất bại: ' . $e -> getMessage());
        }
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = $this -> r -> find($id);
        Gate::authorize('delete', $role);
        if(!$role){
            Session::flash('error', 'Vai trò không tồn tại');
            return redirect() -> back();
        }
        $name = $role -> name;
        $role -> permissions() -> detach();
        $role -> delete();

        Session::flash('success', 'Xóa vai trò ' . $name . ' thành công');
        return redirect() -> back();
    }
}
