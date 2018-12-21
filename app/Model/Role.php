<?php
/**
 * Class Role
 * @package App\Model
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/9 11:22 AM
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role  extends Model
{
    use SoftDeletes;

    protected $table = 'rbac_roles';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'alias',
        'meta_description',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'

    ];


    public function members()
    {
        return $this->morphedByMany(Member::class, 'rbac_roleable');
    }


    public function nodes()
    {
        return $this->morphedByMany(Node::class, 'rbac_roleable');
    }



}