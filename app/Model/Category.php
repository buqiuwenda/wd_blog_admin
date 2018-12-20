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

class Category  extends Model
{
    use SoftDeletes;

    protected $table = 'categorys';

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'parent_id',
        'name',
        'path',
        'description',
        'level',
        'created_at',
        'updated_at',
        'deleted_at'

    ];



}