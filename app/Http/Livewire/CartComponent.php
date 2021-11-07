<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    /**
     * Increase the quantity of the product in the cart
     *
     * @param  mixed $rowId
     * @return void
     */
    public function increaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty  = $product->qty + 1;
        Cart::update($rowId, $qty);
        return back();
    }

    /**
     * Decrease the quantity of the product in the cart
     *
     * @param  mixed $rowId
     * @return void
     */
    public function decreaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty  = $product->qty - 1;
        Cart::update($rowId, $qty);
        return back();
    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
