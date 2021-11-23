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
        $product = Cart::instance('cart')->get($rowId);
        $qty  = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);

        $this->emitTo('cart-count-component', 'refreshComponent');

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
        $product = Cart::instance('cart')->get($rowId);
        $qty  = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        $this->emitTo('cart-count-component', 'refreshComponent');
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
        Cart::instance('cart')->remove($rowId);
        $this->emitTo('cart-count-component', 'refreshComponent');
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
        Cart::instance('cart')->destroy();
        session()->flash('success', 'All products has been removed from the cart');
    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
