<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;


class SearchComponent extends Component
{
    public $sorting, $pagesize, $search, $product_cat, $product_cat_id;


    public function mount()
    {
        $this->sorting  = 'default';
        $this->pagesize = 12;

        $this->fill(request()->only(
            'search',
            'product_cat',
            'product_cat_id',
        ));
    }

    /**
     *  This method store the data in the cart
     * Bu metod cart içerisine verileri saklar
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

    use WithPagination;
    /**
     * Render the component.
     *
     * @return void
     */
    public function render()
    {
        if ($this->sorting == 'date') {
            $products = Product::where('name', 'like', '%' . $this->search . '%')->where('category_id', 'like', '%' . $this->product_cat_id . '%')->orderBy('created_at', 'DESC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price') {
            $products = Product::where('name', 'like', '%' . $this->search . '%')->where('category_id', 'like', '%' . $this->product_cat_id . '%')->orderBy('regular_price', 'ASC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price-desc') {
            $products = Product::where('name', 'like', '%' . $this->search . '%')->where('category_id', 'like', '%' . $this->product_cat_id . '%')->orderBy('regular_price', 'DESC')->paginate($this->pagesize);
        } else {
            $products = Product::where('name', 'like', '%' . $this->search . '%')->where('category_id', 'like', '%' . $this->product_cat_id . '%')->paginate($this->pagesize);
        }

        $categories = Category::all();





        return view('livewire.search-component', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.base');
    }
}
