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

class Tag  extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'tag',
        'title',
        'meta_description',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

}