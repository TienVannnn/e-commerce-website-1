<?php

namespace App\Policies;

use App\Models\Manager;
use App\Models\Category;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Config;

class CategoryPolicy
{
    /**
     * Determine whether the Manager can view any models.
     */
    public function viewAny(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.list-category'));
    }

    /**
     * Determine whether the Manager can view the model.
     */
    public function view(Manager $manager, Category $category): bool
    {
        //
    }

    /**
     * Determine whether the Manager can create models.
     */
    public function create(Manager $manager): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.add-category'));
    }

    /**
     * Determine whether the Manager can update the model.
     */
    public function update(Manager $manager, Category $category): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.edit-category'));
    }

    /**
     * Determine whether the Manager can delete the model.
     */
    public function delete(Manager $manager, Category $category): bool
    {
        return $manager -> checkPermissionAccess(Config::get('permissions.keycode.delete-category'));
    }

    /**
     * Determine whether the Manager can restore the model.
     */
    public function restore(Manager $manager, Category $category): bool
    {
        //
    }

    /**
     * Determine whether the Manager can permanently delete the model.
     */
    public function forceDelete(Manager $manager, Category $category): bool
    {
        //
    }
}
