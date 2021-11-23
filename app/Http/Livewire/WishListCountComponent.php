<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WishListCountComponent extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];

    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.wish-list-count-component');
    }
}
