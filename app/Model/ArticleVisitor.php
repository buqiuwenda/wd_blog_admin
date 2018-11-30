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

class ArticleVisitor  extends Model
{
    use SoftDeletes;

    protected $table = 'article_visitors';

    protected $fillable = [
        'article_id',
        'user_id',
        'ip',
        'clicks',
        'created_at',
        'updated_at'

    ];



}