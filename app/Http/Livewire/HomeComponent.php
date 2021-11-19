<?php

namespace App\Http\Livewire;

use App\Models\HomeSlider;
use App\Models\Product;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $sliders = HomeSlider::where('status', 1)->get();

        $lProducts = Product::orderBy('created_at', 'Desc')->get()->take(8);

        return view('livewire.home-component', compact('sliders', 'lProducts'))->layout('layouts.base');

        //return view('livewire.home-component', [
        //    'sliders' => $sliders,
        //])->layout('layouts.base');
    }
}
