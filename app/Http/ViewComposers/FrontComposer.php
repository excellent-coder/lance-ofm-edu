<?php

namespace App\Http\ViewComposers;

use App\Models\WebSegment;
use Illuminate\View\View;

class FrontComposer
{
    public function compose(View $view)
    {
        $web_title = web_setting('general', 'title', 'comming soon');

        $currency = web_setting('general', 'currency');
        $currency_symbol = web_setting('general', 'currency_symbol');

        if (!$web_title) {
            $web_title = 'comming soon';
        }

        $view
            ->with(
                compact(
                    'web_title',
                    'currency',
                    'currency_symbol'
                )
            );
    }
}
