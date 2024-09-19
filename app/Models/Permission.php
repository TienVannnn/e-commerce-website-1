<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'keycode',
        'description',
        'parent_id',
        'active'
    ];
    public function roles(){
        return $this -> belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
    }

    public function permissionChildrent(){
        return $this -> hasMany(Permission::class, 'parent_id');
    }
}
