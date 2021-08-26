<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Image;
use App\Models\ImagePart;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Program;

class HomeController extends Controller
{
    public function home()
    {
        $about = Page::where('name', 'about')->first();
        $benefits = Page::where('name', 'professional_benefits')->first();
        $qualities = Page::where('name', 'acceptable_qualifications')->first();
        $homeImg = ImagePart::where('part', 'home')->first();
        $coursePage = Page::where('name', 'courses')->first();
        $programs = Program::whereActive('1')->get();

        // return Page::all();
        // return $benefits;
        // return $programs;
        return view('frontend.home', compact(
            'about',
            'benefits',
            'homeImg',
            'qualities',
            'coursePage',
            'programs'
        ));
    }
}
