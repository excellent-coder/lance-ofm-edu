<?php

namespace App\Http\ViewComposers;

use App\Models\WebSegment;
use Illuminate\View\View;

class FrontComposer
{
    public function compose(View $view)
    {
        $web_title = WebSegment::where('name', 'title')->first();
        if (!$web_title) {
            $web_title = 'comming soon';
        }

        $view
            ->with(
                compact(
                    'web_title'
                )
            );
    }
}
