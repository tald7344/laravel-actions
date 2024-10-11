<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function roles($role)
    {
        return $this->belongsToMany(Role::class, 'permission_role_table', 'permission', 'role')->where('id',$role);
    }
    public function permissions_role(){
        return $this->hasMany(RolePermissionView::class , 'permission','id');
    }
}
