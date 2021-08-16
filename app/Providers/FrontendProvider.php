<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Course;
use App\Models\ProductCat;
use App\Models\Program;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\UserCategory;
use Illuminate\Support\Facades\Auth;

class FrontendProvider extends ServiceProvider
{


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['admin.dashboards.index', 'admin.settings.index', 'admin.users.index'],
            'App\Http\ViewComposers\AdminComposer'
        );

        View::composer('*', 'App\Http\ViewComposers\FrontComposer');
        View::composer('layouts.admin', 'App\Http\ViewComposers\LayoutAdminComposer');

        view()->composer('frontend.portal.includes.sidebar', function ($view) {
            $userCats  = UserCategory::where('parent_id', NULL)
                ->where('visibility', 1)
                ->orderBy('name')->get();
            // all the programms
            $programms = Application::where('user_id', Auth::id())
                ->get(['user_category_id'])->whereNotNull('user_category_id');

            // return $userCats;
            $view
                ->with(compact(
                    'userCats',
                    'programms',
                ));
        });

        view()->composer('includes.shop.sidebar', function ($view) {
            $superShopCats = ProductCat::whereNull('super_parent_id')->get();
            $view->with(compact('superShopCats'));
        });

        view()->composer('frontend.scs.includes.sidebar', function ($view) {
            $programs = Program::where('active', 1)
                ->where('is_program', 1)
                ->where('visibility', '<>', 2)
                ->get();

            $userPrograms = auth('scs')->user()->programs;
            $view->with(compact('programs', 'userPrograms'));
        });

        view()->composer('includes.navbar', function ($view) {
            $navPrograms = Program::where('active', 1)
                ->where('is_program', 1)
                ->where('visibility', '<', 3)
                ->get();
            $view->with(compact('navPrograms'));
        });
    }
}
