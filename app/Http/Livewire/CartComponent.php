<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use Carbon\Carbon;
use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
    public $haveCouponCode,
        $couponCode,
        $discount,
        $subtotalAfterDiscount,
        $taxAfterDiscount,
        $totalAfterDiscount;

    /**
     * Increase the quantity of the product in the cart
     * Sepetteki ürünün miktarını arttırır.
     * 
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

    /**
     * Switch the cart to the wishlist
     *
     * @param  mixed $rowId
     * @return void
     */
    public function switchToSaveForLater($rowId)
    {
        $item = Cart::instance('cart')->get($rowId);
        Cart::instance('cart')->remove($rowId);
        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Models\Product');
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('success', 'Product has been saved for later');
    }

    /**
     * Move the product from the wishlist to the cart
     *
     * @param  mixed $rowId
     * @return void
     */
    public function moveToCart($rowId)
    {
        $item = Cart::instance('saveForLater')->get($rowId);
        Cart::instance('saveForLater')->remove($rowId);
        Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Models\Product');
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('s_success', 'Product has been moved to cart');
    }


    /**
     * Delete the product from the wishlist
     *
     * @param  mixed $rowId
     * @return void
     */
    public function deleteFromSaveForLater($rowId)
    {
        Cart::instance('saveForLater')->remove($rowId);
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('s_success', 'Product has been removed from the Save For Later');
    }


    /**
     * Apply the coupon code to the cart
     *
     * @return void
     */
    public function applyCouponCode()
    {
        $coupon = Coupon::where('code', $this->couponCode)->where('expiry_date', '>=', Carbon::today())->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();
        if ($coupon) {
            session()->put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value,
            ]);
            session()->flash('coupon_message', 'Coupon has been applied successfully');
        } else {
            session()->flash('coupon_message', 'Coupon code is invalid');
        }
    }


    /**
     * Calculate the discount and tax
     *
     * @return void
     */
    public function calculateDiscounts()
    {
        if (session()->has('coupon')) {
            if ((session()->get('coupon')['type'] == 'fixed')) {
                $this->discount = session()->get('coupon')['value'];
            } else {
                $this->discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value']) / 100;
            }
            $this->subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $this->discount;
            $this->taxAfterDiscount = ($this->subtotalAfterDiscount * config('cart.tax')) / 100;
            $this->totalAfterDiscount = $this->subtotalAfterDiscount + $this->taxAfterDiscount;
        }
    }


    /**
     * Remove coupon  
     *
     * @return void
     */
    public function removeCoupon()
    {
        session()->forget('coupon');
    }


    /**
     * Checkout the cart
     *
     * @return void
     */
    public function checkout()
    {
        if (Auth::check()) {
            return redirect()->route('checkout');
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Amount of the cart
     * Sepetin toplam miktarı
     *
     * @return void
     */
    public function setAmountForCheckout()
    {
        if (!Cart::instance('cart')->count() > 0) {
            session()->forget('checkout');
            return;
        }

        if (session()->has('coupon')) {
            session()->put('checkout', [
                'subtotal' => $this->subtotalAfterDiscount,
                'discount' => $this->discount,
                'tax' => $this->taxAfterDiscount,
                'total' => $this->totalAfterDiscount,
            ]);
        } else {
            session()->put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        if (session()->has('coupon')) {
            if (Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value']) {
                session()->forget('coupon');
            } else {
                $this->calculateDiscounts();
            }
        }
        $this->setAmountForCheckout();
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
