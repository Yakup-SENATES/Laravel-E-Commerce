<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;


class ShopComponent extends Component
{
    public $sorting, $pagesize, $min_price, $max_price;

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount()
    {
        $this->sorting  = 'default';
        $this->pagesize = 12;
        $this->min_price = 1;
        $this->max_price = 1000;
    }

    /**
     *  This method store the data in the cart
     * 
     * @param  mixed $product_name
     * @param  mixed $product_id
     * @param  mixed $product_price
     * @return void
     */
    public function store($product_name, $product_id, $product_price)
    {
        Cart::instance('cart')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success', 'Product added to cart!');
        return redirect()->route('cart');
    }

    /**
     * Add To Wish List Function
     *
     * @param  mixed $product_id
     * @param  mixed $product_name
     * @param  mixed $product_price
     * @return void
     */
    public function addToWhishList($product_id, $product_name, $product_price)
    {
        Cart::instance('wishlist')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
    }

    use WithPagination;
    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        if ($this->sorting == 'date') {
            $products = Product::whereBetween('regular_price', [$this->min_price, $this->max_price])->orderBy('created_at', 'DESC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price') {
            $products = Product::whereBetween('regular_price', [$this->min_price, $this->max_price])->orderBy('regular_price', 'ASC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price-desc') {
            $products = Product::whereBetween('regular_price', [$this->min_price, $this->max_price])->orderBy('regular_price', 'DESC')->paginate($this->pagesize);
        } else {
            $products = Product::whereBetween('regular_price', [$this->min_price, $this->max_price])->paginate($this->pagesize);
        }

        $categories = Category::all();

        return view('livewire.shop-component', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.base');
    }
}
