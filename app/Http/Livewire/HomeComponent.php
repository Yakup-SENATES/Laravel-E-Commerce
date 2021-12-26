<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Cart;

class HomeComponent extends Component
{
    public function render()
    {
        //session()->put('utype', Auth::user()['utype']);
        //dd(session('utype'));

        $sliders = HomeSlider::where('status', 1)->get();

        $lProducts = Product::orderBy('created_at', 'Desc')->get()->take(8);
        $category = HomeCategory::find(1);
        $cats = explode(',', $category->sel_categories);
        $categories = Category::whereIn('id', $cats)->get();
        $no_of_products = $category->no_of_products;
        //on sale products
        $sProducts = Product::where('sale_price', '!=', 0)->inRandomOrder()->get()->take(8);
        $sale = Sale::find(1);

        //oturum açılmış kullanıcı varsa ve sepeti boş değilse
        //sepeti database e kaydediyoruz.

        if (Auth::check()) {
            Cart::instance('cart')->restore(Auth::user()->email);
        }

        return view('livewire.home-component', compact('sliders', 'lProducts', 'categories', 'no_of_products', 'sProducts', 'sale'))->layout('layouts.base');
    }
}
