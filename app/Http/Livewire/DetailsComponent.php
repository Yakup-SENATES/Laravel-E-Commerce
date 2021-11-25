<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;
use Cart;


class DetailsComponent extends Component
{
    public $slug, $qty;


    /**
     * Firt method called when component is mounted
     *
     * @param  mixed $slug
     * @return void
     */
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->qty = 1;
    }

    /**
     * Store the product details in the cart session
     *
     * @param  mixed $product_id
     * @param  mixed $product_name
     * @param  mixed $product_price
     * @return void
     */
    public function store($product_id, $product_name, $product_price)
    {

        Cart::instance('cart')->add($product_id, $product_name, $this->qty, $product_price)->associate('App\Models\Product');
        session()->flash('success', 'Product added to cart!');
        return redirect()->route('cart');
    }


    /**
     * Increase the quantity of the product in the cart session
     *
     * @return void
     */
    public function increaseQuantity()
    {
        $this->qty++;
    }


    /**
     * Decrease the quantity of the product in the cart session
     *
     * @return void
     */
    public function decreaseQuantity()
    {
        if ($this->qty > 1) {
            $this->qty--;
        }
    }


    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        $product = Product::where('slug', $this->slug)->first();
        //Rastgele product seçme


        $popular_products = Product::inRandomOrder()->limit(4)->get();
        // Aynı kategoriye ait ürünleri seçme
        $related_products = Product::whereCategoryId($product->category_id)->inRandomOrder()->limit(5)->get()->except($product->id);

        $sale = Sale::find(1);
        return view('livewire.details-component', [
            'product' => $product,
            'popular_products'  => $popular_products,
            'related_products' => $related_products,
            'sale' => $sale,
        ])->layout('layouts.base');
    }
}
