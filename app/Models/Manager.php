<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles(){
        return $this -> belongsToMany(Role::class, 'role_manager', 'manager_id', 'role_id');
    }

    public function checkPermissionAccess($code){
        $roles = Auth::guard('manager') -> user() -> roles;
        foreach($roles as $role){
            $permission = $role -> permissions;
            if($permission -> contains('keycode', $code)){
                return true;
            }
        }
        return false;
    }
}
