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

class Discussion  extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'user_id',
        'last_user_id',
        'title',
        'content',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'

    ];


    public function comments()
    {
        return $this->morphMan(Comment::class, 'commentable');
    }
}