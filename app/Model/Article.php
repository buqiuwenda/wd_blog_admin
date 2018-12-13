<?php
/**
 * Class Role
 * @package App\Model
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/9 11:22 AM
 */
namespace App\Model;

use App\Tools\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
use App\Tools\Translate\YouDao;

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
        'status',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable');
    }



    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $youDao = new YouDao();
        $en_value = $youDao->translate($value);

        $this->setUniqueSlug($en_value, str_random(5));
    }


    public function setUniqueSlug($value, $extra)
    {
        $slug = str_slug($value.'-'.$extra);

        $info = $this->query()->where('slug', '=', $slug)->first();

        if($info){
            $this->setUniqueSlug($slug, (int) $extra + 1);
            return ;
        }

        $this->attributes['slug'] = $slug;
    }


    public function setContentAttribute($value)
    {
        $content = [
           'raw' => $value,
           'html' => (new Markdowner())->convertMarkdownToHtml($value)
        ];

        $this->attributes['content'] = json_encode($content);
    }

}