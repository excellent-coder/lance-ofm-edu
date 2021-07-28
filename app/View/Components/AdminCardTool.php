<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminCardTool extends Component
{
    public $title;
    public $links;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $links = false)
    {
        $this->title = $title;
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-card-tool');
    }
}
