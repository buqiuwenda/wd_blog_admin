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

class Article  extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'category_id',
        'member_id',
        'last_member_id',
        'slug',
        'title',
        'subtitle',
        'content',
        'page_image',
        'meta_description',
        'is_original',
        'is_draft',
        'view_count',
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at'

    ];



}