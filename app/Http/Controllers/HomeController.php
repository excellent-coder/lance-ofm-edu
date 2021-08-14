<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Image;
use App\Models\ImagePart;
use Illuminate\Http\Request;
use App\Models\Page;

class HomeController extends Controller
{
    public function home()
    {
        $about = Page::where('name', 'about')->first();
        $benefits = Page::where('name', 'professional_benefits')->first();
        $qualities = Page::where('name', 'acceptable_qualifications')->first();
        $homeImg = ImagePart::where('part', 'home')->first();
        $coursePage = Page::where('name', 'courses')->first();
        $courses = Course::all();

        // return Page::all();
        // return $benefits;
        return view('frontend.home', compact(
            'about',
            'benefits',
            'homeImg',
            'qualities',
            'coursePage',
            'courses'
        ));
    }
}
