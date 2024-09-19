<?php

namespace App\Policies;

use App\Models\Manager;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.list-permission'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Manager $manager, Permission $permission): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.add-permission'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Manager $manager, Permission $permission): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.edit-permission'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Manager $manager, Permission $permission): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.delete-permission'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Manager $manager, Permission $permission): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Manager $manager, Permission $permission): bool
    {
        //
    }
}
