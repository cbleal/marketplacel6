<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // RECUPERAR CATEGORIES
        $categories = \App\Category::all();

        // COMPARTILHAR EM TODAS AS VIEWS
        // view()->share('categories', $categories);

        // USANDO COMPOSER: VIEW ESPECÍFICA
        // view()->composer('welcome', function($view) use($categories) {
        //     $view->with('categories', $categories);
        // });

        // USANDO COMPOSER: TODAS VIEWS
        // view()->composer('*', function($view) use($categories) {
        //     $view->with('categories', $categories);
        // });

        // USANDO COMPOSER: ATRAVÉS DE CHAMADA A UMA CLASSE
        view()->composer('layouts.front', 'App\Http\Views\CategoryViewComposer@compose');
    }
}
