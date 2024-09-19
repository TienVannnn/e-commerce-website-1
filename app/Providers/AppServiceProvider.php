<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Manager;
use App\Models\Product;
use App\Models\Category;
use App\Models\Permission;
use App\Policies\RolePolicy;
use App\Policies\ManagerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        // Gate::define('category-list', function (Manager $manager) {
        //     return $manager -> checkPermissionAccess('list_category');
        // });
        // Gate::define('add-config', function (Manager $manager) {
        //     return $manager -> checkPermissionAccess('add_config');
        // });
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Manager::class, ManagerPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
    }
}
