<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\Manager;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config;

class MenuPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.list-menu'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Manager $manager, Menu $menu): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.add-menu'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Manager $manager, Menu $menu): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.edit-menu'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Manager $manager, Menu $menu): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.delete-menu'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Manager $manager, Menu $menu): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Manager $manager, Menu $menu): bool
    {
        //
    }
}
