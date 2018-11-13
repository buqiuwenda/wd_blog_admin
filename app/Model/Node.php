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

class Node  extends Model
{
    use SoftDeletes;

    protected $table = 'rbac_nodes';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'parent_id',
        'routing',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

}