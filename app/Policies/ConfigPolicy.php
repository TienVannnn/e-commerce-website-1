<?php

namespace App\Policies;

use App\Models\Manager;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config as ConfigSP;
use App\Models\Config;

class ConfigPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(ConfigSP::get('permissions.keycode.list-config'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Manager $manager, Config $config): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(ConfigSP::get('permissions.keycode.add-config'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Manager $manager, Config $config): bool
    {
        return $manager -> checkPermissionAccess(ConfigSP::get('permissions.keycode.edit-config'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Manager $manager, Config $config): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.delete-config'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Manager $manager, Config $config): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Manager $manager, Config $config): bool
    {
        //
    }
}
