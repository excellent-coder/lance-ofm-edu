<?php

namespace App\Http\ViewComposers;

use App\User;
use App\Post;
use App\Product;
use App\Usershop;
use App\Category;
use App\Setting;
use Illuminate\View\View;
use App\Profile;

class AdminComposer
{
    public function compose(View $view)
    {
        $users = User::latest()->get();
        // $products = Product::all();
        // $usershop = Usershop::all();
        $blog_count = Post::all()->count();
        $category_count = Category::all()->count();
        $user_count = User::all()->count();
        $product_count = Product::all()->count();
        $usershop_count = Usershop::all()->count();
        $profile_count = Profile::all()->count();
        $admin = Setting::where('type', 'admin')->first();


        $title = 'worldtok';
        $view
            ->with(compact(
                'blog_count',
                'product_count',
                'usershop_count',
                'category_count',
                'profile_count',
                'user_count',
                'products',
                'users',
                'usershop',
                'site',
                'title',
                'admin'
            ));
    }
}
