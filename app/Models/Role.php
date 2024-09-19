<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'active'
    ];
    public function managers(){
        return $this -> belongsToMany(Manager::class, 'role_manager', 'role_id', 'manager_id');
    }

    public function permissions(){
        return $this -> belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }
}
