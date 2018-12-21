<?php
/**
 * Class Role
 * @package App\Model
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/9 11:22 AM
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleVisitor  extends Model
{


    protected $table = 'article_visitors';

    protected $fillable = [
        'article_id',
        'user_id',
        'ip',
        'clicks',
        'created_at',
        'updated_at'

    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

}