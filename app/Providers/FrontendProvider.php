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

        view()->composer('frontend.pgs.*', function ($view) {
            /**
             * $pauth = authenticated program stiudent
             */
            $pauth = Auth::user('pgs');
            // current program
            $program = auth('pgs')->user()->program;
            $view->with(compact('pauth', 'program'));
        });

        view()->composer('includes.shop.sidebar', function ($view) {
            $superShopCats = ProductCat::whereNull('super_parent_id')->get();
            $view->with(compact('superShopCats'));
        });

        view()->composer('frontend.scs.includes.sidebar', function ($view) {
            $programs = Program::where('active', 1)
                ->where('is_program', 1)
                ->where('visibility', '!=', 2)
                ->get();

            $userPrograms = auth('scs')->user()->programs;
            $view->with(compact('programs', 'userPrograms'));
        });

        view()->composer('includes.navbar', function ($view) {
            $navPrograms = Program::where('active', 1)
                // ->where('is_program', 1)
                // ->where('visibility', '<', 3)
                ->get();
            $view->with(compact('navPrograms'));
        });

        // user dashboards
        view()->composer([
            'frontend.scs.*',
            'frontend.pgs.*',
            'frontend.mem.*'
        ], function ($view) {
            foreach (['pgs', 'scs', 'mem'] as $g) {
                if ($auth = auth($g)->user()) {
                    break;
                }
            }
            $view->with(compact('auth'));
        });
    }
}
