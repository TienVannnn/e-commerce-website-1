<?php

namespace App\Policies;

use App\Models\Manager;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config;

class ManagerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.list-manager'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Manager $manager, Manager $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.add-manager'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Manager $manager, Manager $model): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.edit-manager'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Manager $manager, Manager $model): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.delete-manager'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Manager $manager, Manager $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Manager $manager, Manager $model): bool
    {
        //
    }
}
