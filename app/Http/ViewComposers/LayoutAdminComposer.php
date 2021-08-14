<?php

namespace App\Http\ViewComposers;

use App\Models\Course;
use App\Models\ImagePart;
use App\Models\Setting;
use App\Models\SettingTag;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


class LayoutAdminComposer
{
    public function compose(View $view)
    {
        $web_title = "Good App";
        $route_name = Route::current()->getName();
        $matches = [0, 1, 2];
        $route = preg_match('/^(admin\.)(.+)$/', $route_name, $matches);
        $route = empty($matches[2]) ? '' : $matches[2];
        $admin_theme = 'light-mode';
        $settingTags = SettingTag::all();
        $imageParts = ImagePart::all();
        $navCourses = Course::all();
        // $admin_theme = 'dark-mode';

        $view
            ->with(compact(
                'web_title',
                'route',
                'admin_theme',
                'settingTags',
                'imageParts',
                'navCourses'
            ));
    }
}
