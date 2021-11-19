<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $sliders = HomeSlider::where('status', 1)->get();

        $lProducts = Product::orderBy('created_at', 'Desc')->get()->take(8);
        $category = HomeCategory::find(1);
        $cats = explode(',', $category->sel_categories);
        $categories = Category::whereIn('id', $cats)->get();
        $no_of_products = $category->no_of_products;

        return view('livewire.home-component', compact('sliders', 'lProducts', 'categories', 'no_of_products'))->layout('layouts.base');

        //return view('livewire.home-component', [
        //    'sliders' => $sliders,
        //])->layout('layouts.base');
    }
}
