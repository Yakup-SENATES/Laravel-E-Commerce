<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class WishlistComponent extends Component
{
    /**
     * Remove item from wishlist
     *
     * @param  mixed $product_id
     * @return void
     */
    public function removeFromWishList($product_id)
    {
        foreach (Cart::instance('wishlist')->content() as $witem) {
            if ($witem->id == $product_id) {
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wish-list-count-component', 'refreshComponent');
                return;
            }
        }
    }


    /**
     * Move product from wishlist to cart
     *
     * @param  mixed $rowId
     * @return void
     */
    public function moveProductFromWishListToCart($rowId)
    {
        $item =  Cart::instance('wishlist')->get($rowId);
        Cart::instance('wishlist')->remove($rowId);
        Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
        $this->emitTo('wish-list-count-component', 'refreshComponent');
        $this->emitTo('cart-count-component', 'refreshComponent');
    }

    /**
     * Render the component view
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.wishlist-component')->layout('layouts.base');
    }
}
