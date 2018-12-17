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

class Comment  extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'content',
        'created_at',
        'updated_at',
        'deleted_at'

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function commentable()
    {
        return $this->morphTo();
    }

    

}