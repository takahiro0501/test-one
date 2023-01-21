<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\FooterLink;


class UserFooter extends Component
{

    public $links;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->links = FooterLink::orderBy('id','asc')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-footer');
    }
}
