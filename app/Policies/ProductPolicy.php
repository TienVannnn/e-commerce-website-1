<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Manager;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config;

class ProductPolicy
{
    /**
     * Determine whether the Manager can view any models.
     */
    public function viewAny(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.list-product'));
    }

    /**
     * Determine whether the Manager can view the model.
     */
    // public function view(Manager $manager, Product $product): bool
    // {
    //     //
    // }

    /**
     * Determine whether the Manager can create models.
     */
    public function create(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.add-product'));
    }

    /**
     * Determine whether the Manager can update the model.
     */
    public function update(Manager $manager, Product $product): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.edit-product'));
    }

    // public function edit(Manager $manager): bool
    // {
    //     dd(Config::get('permissions.keycode.edit-product'));
    //     return $manager -> checkPermissionAccess(Config::get('permissions.keycode.edit-product'));
    // }

    /**
     * Determine whether the Manager can delete the model.
     */
    public function delete(Manager $manager, Product $product): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.delete-product'));
    }

    /**
     * Determine whether the Manager can restore the model.
     */
    // public function restore(Manager $manager, Product $product): bool
    // {
    //     //
    // }

    /**
     * Determine whether the Manager can permanently delete the model.
     */
    // public function forceDelete(Manager $manager, Product $product): bool
    // {
    //     //
    // }
}
