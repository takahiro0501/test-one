<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Sentence;

class UserHeader extends Component
{
    public $sentence1;
    public $sentence2;    

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $sentence1 = Sentence::where('no',1)->first();
        $sentence2 = Sentence::where('no',2)->first();

        $this->sentence1 = $sentence1->sentence;
        $this->sentence2 = $sentence2->sentence;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-header');
    }
}
