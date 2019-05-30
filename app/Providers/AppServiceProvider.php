<?php

namespace App\Providers;

use App\Model\Member;
use App\Model\Node;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Model\Article;
use App\Model\Discussion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
                               'discussions' => Discussion::class,
                               'articles'    => Article::class,
                               'member' => Member::class,
                               'node' => Node::class
                           ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
