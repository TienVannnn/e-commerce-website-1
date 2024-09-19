<?php

namespace App\Policies;

use App\Models\Slider;
use App\Models\Manager;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config;

class SliderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.list-slider'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Manager $manager, Slider $slider): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.add-slider'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Manager $manager, Slider $slider): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.edit-slider'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Manager $manager, Slider $slider): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.delete-slider'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Manager $manager, Slider $slider): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Manager $manager, Slider $slider): bool
    {
        //
    }
}
