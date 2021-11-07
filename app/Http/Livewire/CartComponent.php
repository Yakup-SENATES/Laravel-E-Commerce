<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    /**
     * Increase the quantity of the product in the cart
     * Sepetteki ürünün miktarını arttırır.
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
     * Sepetteki ürünün miktarını azaltır
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


    /**
     * Sepetteki ürünü siler
     * Remove the product from the cart
     *
     * @param  mixed $rowId
     * @return void
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        session()->flash('success', 'Product has been removed from the cart');
    }

    /**
     * Destroy all the products in the cart
     *  Sepetin tüm ürünlerini siler
     *
     * @param  mixed $rowId
     * @return void
     */
    public function destroyAll()
    {
        Cart::destroy();
        session()->flash('success', 'All products has been removed from the cart');
    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
