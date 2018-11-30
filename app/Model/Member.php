<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;
    const ROOT_ROLE = 'rootAdmin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','nickname', 'email', 'confirm_code','password','avatar','status','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function roles()
    {
        return $this->morphToMany(Role::class, 'rbac_roleable');
    }

    public function permissionCheck($route_name)
    {
        $role = $this->roles()->first();

        if($role['status'] == 'disable'){
            return false;
        }

        if($role['alias'] == self::ROOT_ROLE){
            return true;
        }

        if(is_white_route($route_name)){
            return true;
        }

        $nodeArr = $this->loadPermission($role['id']);
        if(in_array($route_name, $nodeArr)){
            return true;
        }

        return false;
    }


    public function loadPermission($roleId)
    {
        $roles = Role::query()->find($roleId);

        $nodes = $roles->nodes()->get();

        $nodeArr = [];
        foreach($nodes->toArray() as $val){
            $nodeArr[] = $val['routing'];
        }

        return $nodeArr;
    }

}
