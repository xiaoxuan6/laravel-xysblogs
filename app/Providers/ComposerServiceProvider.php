<?php

namespace App\Providers;

use App\Http\ViewComposers\CommonComposer;
use App\Http\ViewComposers\WebComposer;
use App\Model\ArticleRecord;
use App\Model\Article;
use App\Model\Banner;
use App\Model\Comment;
use App\Model\Discuss;
use App\Model\Label;
use App\Model\Link;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View()->composer('layouts.comment', CommonComposer::class);
        View()->composer('layouts.web', WebComposer::class);
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
