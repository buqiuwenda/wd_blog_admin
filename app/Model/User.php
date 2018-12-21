<?php
/**
 * Class Role
 * @package App\Model
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/9 11:22 AM
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User  extends Model
{
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'name',
        'nickname',
        'avatar',
        'email',
        'confirm_code',
        'password',
        'remember_token',
        'status',
        'created_at',
        'updated_at',
    ];



}