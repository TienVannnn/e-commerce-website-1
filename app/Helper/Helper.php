<?php
namespace App\Helper;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Config;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route; // Import thêm Route để sử dụng hàm route()

class Helper
{
    public static function menu($menus, $parent_id = 0, $char = '')
    {
        $html = '';

        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                // Tạo URL thủ công cho route
                $editUrl = route('menus.edit', $menu->id);
                $deleteUrl = route('menus.destroy', $menu->id);
                $parentCategory = Menu::find($menu->parent_id);
                $parentName = $parentCategory ? $parentCategory->name : '<span class="btn btn-info btn-xs">No<span>';

                $html .= '
                    <tr>
                        <td>' . $menu->id . '</td>
                        <td>' . $char . $menu->name . '</td>
                        <td>' . $menu->slug . '</td>
                        <td>' . $parentName . '</td>
                        <td>' . self::active($menu->active) . '</td>
                        <td>
                             <a href="' . $editUrl . '" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="' . $deleteUrl . '" method="POST" style="display: inline">
                                ' . method_field('DELETE') . '
          
                                ' . csrf_field() . '
                                <button class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(\'Are you sure you want to delete this category?\')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                ';

                unset($menus[$key]);

                $html .= self::menu($menus, $menu->id, $char . '|--');
            }
        }
        return $html;
    }

    public static function category($categories, $parent_id = 0, $char = '')
    {
        $html = '';

        foreach ($categories as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $editUrl = route('category.edit', $menu->id);
                $deleteUrl = route('category.destroy', $menu->id);
                $parentCategory = Category::find($menu->parent_id);
                $parentName = $parentCategory ? $parentCategory->name : '<span class="btn btn-info btn-xs">No<span>';

                $html .= '
                    <tr>
                        <td>' . $menu->id . '</td>
                        <td>' . $char . $menu->name . '</td>
                        <td>' . $menu->slug . '</td>
                        <td> <img src="/uploads/category/' . $menu->img . '" width ="50"/></td>
                        <td>' . $parentName . '</td>
                        <td>' . self::active($menu->active) . '</td>
                        <td>
                             <a href="' . $editUrl . '" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="' . $deleteUrl . '" method="POST" style="display: inline">
                                ' . method_field('DELETE') . '
                                ' . csrf_field() . '
                                <button class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(\'Are you sure you want to delete this category?\')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                ';

                unset($categories[$key]);

                $html .= self::category($categories, $menu->id, $char . '|--');
            }
        }

        return $html;
    }

    public static function permission($permissions, $parent_id = 0, $char = '')
    {
        $html = '';

        foreach ($permissions as $key => $va) {
            if ($va->parent_id == $parent_id) {
                $editUrl = route('permissions.edit', $va->id);
                $deleteUrl = route('permissions.destroy', $va->id);
                $parentCategory = Permission::find($va->parent_id);
                $parentName = $parentCategory ? $parentCategory->name : '<span class="btn btn-info btn-xs">No<span>';

                $html .= '
                    <tr>
                        <td>' . $va->id . '</td>
                        <td>' . $char . $va->name . '</td>
                        <td>' . $va -> keycode . '</td>
                        <td>' . $parentName . '</td>
                        <td>' . self::active($va->active) . '</td>
                        <td>
                             <a href="' . $editUrl . '" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="' . $deleteUrl . '" method="POST" style="display: inline">
                                ' . method_field('DELETE') . '
                                ' . csrf_field() . '
                                <button class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(\'Are you sure you want to delete this permission?\')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                ';

                unset($permissions[$key]);

                $html .= self::permission($permissions, $va->id, $char . '|--');
            }
        }

        return $html;
    }

    public static function active($active = 0): string
    {
        return $active == 0 ? '<span class="btn btn-danger btn-xs">No</span>'
            : '<span class="btn btn-success btn-xs">Yes</span>';
    }

    public static function getConfig($key){
        $config = Config::where('key', $key) -> where('active', 1) -> first();
        if($config){
            return $config -> value;
        }
        return null;
    }
}
