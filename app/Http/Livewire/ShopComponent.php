<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;


class ShopComponent extends Component
{
    public $sorting, $pagesize;


    public function mount()
    {
        $this->sorting  = 'default';
        $this->pagesize = 12;
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
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success', 'Product added to cart!');
        return redirect()->route('cart');
    }

    use WithPagination;
    public function render()
    {
        if ($this->sorting == 'date') {
            $products = Product::orderBy('created_at', 'DESC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price') {
            $products = Product::orderBy('regular_price', 'ASC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price-desc') {
            $products = Product::orderBy('regular_price', 'DESC')->paginate($this->pagesize);
        } else {
            $products = Product::paginate($this->pagesize);
        }

        $categories = Category::all();

        return view('livewire.shop-component', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.base');
    }
}
