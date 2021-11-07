<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;


class ShopComponent extends Component
{
    public function store($product_name, $product_id, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success', 'Product added to cart!');
        return redirect()->route('cart');
    }

    use WithPagination;
    public function render()
    {
        $products = Product::paginate(12);
        return view('livewire.shop-component', [
            'products' => $products,
        ])->layout('layouts.base');
    }
}
