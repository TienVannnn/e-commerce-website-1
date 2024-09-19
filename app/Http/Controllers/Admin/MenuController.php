<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    protected $htmlSelected;
    public function __construct()
    {
        $this -> htmlSelected = '';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Menu::class);
        $menus = Menu::orderByDesc('id') -> paginate(4);
        $title = 'Menu List';
        return view('admin.menu.index', compact('menus', 'title'));
    }

    public function menuRecusiveCreate($id, $text = '')
    {
        $data = Menu::where('active', 1)->get();
        foreach ($data as $va) {
            if ($va->parent_id == $id) {
                $this->htmlSelected .= '<option value="' . $va->id . '">' . $text . $va->name . '</option>';
                $this->menuRecusiveCreate($va->id, $text . '|-');
            }
        }
        return $this->htmlSelected;
    }

    public function menuRecusiveEdit($id, $text = '', $idMenu)
    {
        $data = Menu::where('active', 1) -> where('id', '!=', $idMenu -> id) ->get();
        foreach ($data as $va) {
            if ($va->parent_id == $id) {
                $selected = ($idMenu->parent_id == $va->id) ? 'selected' : '';
                $this->htmlSelected .= '<option value="' . $va->id . '" ' . $selected . '>' . $text . $va->name . '</option>';
                $this->menuRecusiveEdit($va->id, $text . '|-', $idMenu);
            }
        }
        return $this->htmlSelected;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Menu::class);
        $htmlOptions = $this -> menuRecusiveCreate(0);
        $title = 'Add new menu';
        return view('admin.menu.create', compact('htmlOptions', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'name' => 'required|unique:menus,name',
            'slug' => 'required|unique:menus,slug',
        ]);
        try{
            $menu = Menu::create($request -> all());
            Session::flash('success', 'Add menu successfully');
        }
        catch(\Exception $err){
            Session::flash('error', 'Add menu failed');
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
        $menu = Menu::find($id);
        Gate::authorize('update', $menu);
        if(!$menu){
            Session::flash('error', 'Menu không tồn tại');
            return redirect() -> back();
        }
        $htmlOptions = $this -> menuRecusiveEdit(0, '', $menu);
        $title = 'Edit menu ' . $menu -> name;
        return view('admin.menu.edit', compact('menu','title', 'htmlOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request -> validate([
            'name' => 'required',
            'slug' => 'required',
        ]);
        try{
            $menu = Menu::find($id);
            if(!$menu){
                Session::flash('error', 'Menu không tồn tại');
                return redirect() -> back();
            }
            $menu -> fill($request -> input()) -> save();
            Session::flash('success', 'Updated menu successfully');
        }
        catch(\Exception $err){
            Session::flash('error', 'Updated menu failed');
        }
        return redirect() -> back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $menu = Menu::find($id);
            Gate::authorize('delete', $menu);
            if (!$menu) {
                Session::flash('error', 'Menu not found');
                return redirect()->back();
            }
            $childMenus = Menu::where('parent_id', $menu->id)->get();

            if($childMenus){
                foreach ($childMenus as $childMenu) {
                    $childMenu-> parent_id = 0;
                    $childMenu -> save();
                }
            }
            $menu->delete();
            Session::flash('success', 'Delete menu successfully');
        } catch (\Exception $err) {
            Session::flash('error', 'Delete menu failed: ' . $err->getMessage());
        }

        return redirect()->back();
    }

}
