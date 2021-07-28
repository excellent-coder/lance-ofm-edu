<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;

class AdminBreadcrumb extends Component
{
    public $paths;
    public $path;
    public $pageTitle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request, $pageTitle = "Dashboard")
    {
        $paths = $request->path();
        $paths = explode('/', $paths);

        $paths = array_diff($paths, ['edit']);

        $this->paths = $paths;

        $this->path = end($paths);

        $this->pageTitle = $pageTitle;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-breadcrumb');
    }
}
