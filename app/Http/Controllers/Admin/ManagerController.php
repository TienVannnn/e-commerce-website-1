<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     protected $m;
     protected $role;
     public function __construct(Manager $manager, Role $role)
     {
        $this -> m = $manager;
        $this -> role = $role;
     }

    public function index()
    {
        Gate::authorize('viewAny', Manager::class);
        $managers = $this -> m -> orderByDesc('id') -> paginate(10);
        $title = 'Danh sách người quản lý';
        return view('admin.manager.index', compact('title', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Manager::class);
        $title = 'Thêm mới người quản lý';
        $roles = $this -> role -> where('active', 1) -> orderByDesc('id') -> get();
        return view('admin.manager.create', compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $cre = $request -> validate([
                'name' => 'required',
                'email' => ['required', 'email', 'unique:managers,email', 'regex:/^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
                'password' => 'required|confirmed'
            ]);
            $manager = $this -> m -> create(array_merge(
                $cre,
                ['password' => Hash::make($request -> password)]
            ));
            if($request -> roles){
                $manager -> roles() -> attach($request -> roles);
            }
            DB::commit();
            Session::flash('success', 'Thêm mới người quản lý thành công');
        }
        catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', 'Thêm mới người quản lý thất bại: '. $e -> getMessage());
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
        $manager = $this -> m -> find($id);
        Gate::authorize('update', $manager);
        if(!$manager){
            Session::flash('error', 'Manager không tồn tại');
            return redirect() -> back();
        }
        $roles = $this -> role -> where('active', 1) -> orderByDesc('id') -> get();
        $roles_managers = $manager -> roles;
        $title = 'Chỉnh sửa manager ' . $manager -> name;
        return view('admin.manager.edit', compact('title', 'manager', 'roles', 'roles_managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            DB::beginTransaction();
            $manager = $this -> m -> find($id);
            if(!$manager){
                Session::flash('error', 'Manager không tồn tại');
                return redirect() -> back();
            }
            $cre = $request -> validate([
                'name' => 'required',
                'email' => ['required', 'email', 'unique:managers,email,' . $manager -> id . ',id', 'regex:/^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/'],
                'password' => 'required'
            ]);
            $manager -> fill(array_merge(
                $cre,
                ['password' => Hash::make($request -> password)]
            ));
            if($request -> roles){
                $manager -> roles() -> sync($request -> roles);
            }
            DB::commit();
            $manager -> save();
            Session::flash('success', 'Cập nhật thành công');
        }
        catch(\Exception $e){
            DB::rollback();
            Session::flash('error', 'Cập nhật thất bại: ' . $e -> getMessage());
        }
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();
            $manager = $this -> m -> find($id);
            Gate::authorize('delete', $manager);
            if(!$manager){
                Session::flash('error', 'Manager không tồn tại');
                return redirect() -> back();
            }
            $name = $manager -> name;
            $manager -> roles() -> detach(); 
            $manager -> delete();
            DB::commit();
            Session::flash('success', 'Xóa người quản lý ' . $name .  ' thành công');
        }
        catch(\Exception $e){
            DB::rollBack();
            Session::flash('error', 'Xóa người quản lý ' . $name . ' thất bại: '. $e -> getMessage());
        }
        return redirect() -> back();
    }
}
