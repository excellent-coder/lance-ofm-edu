<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminModal extends Component
{
    public $title;
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = "Please Update", $id = 'general-modal')
    {
        $this->title = $title;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-modal');
    }
}
