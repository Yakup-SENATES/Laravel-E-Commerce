<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class CategoryComponent extends Component
{
    public $sorting, $pagesize, $category_slug, $scategory_slug;


    /**
     * this is a constructor function.
     *
     * @param  mixed $category_slug
     * @param  mixed $scategory_slug
     * @return void
     */
    public function mount($category_slug, $scategory_slug = null)
    {
        $this->category_slug = $category_slug;
        $this->scategory_slug = $scategory_slug;
        $this->sorting =  'default';
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
        Cart::instance('cart')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success', 'Product added to cart!');
        return redirect()->route('cart');
    }

    use WithPagination;
    public function render()
    {
        $category_id = null;
        $category_name = "";
        $filter = "";

        if ($this->scategory_slug) {
            $scategory = Subcategory::where('slug', $this->scategory_slug)->first();
            $category_id = $scategory->id;
            $category_name = $scategory->name;
            $filter = 'sub';
        } else {
            $category = Category::where('slug', $this->category_slug)->first();
            $category_id = $category->id;
            $category_name = $category->name;
            $filter = '';
        }


        if ($this->sorting == 'date') {
            $products = Product::where($filter . 'category_id', $category_id)->orderBy('created_at', 'DESC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price') {
            $products = Product::where($filter . 'category_id', $category_id)->orderBy('regular_price', 'ASC')->paginate($this->pagesize);
        } else if ($this->sorting == 'price-desc') {
            $products = Product::where($filter . 'category_id', $category_id)->orderBy('regular_price', 'DESC')->paginate($this->pagesize);
        } else {
            $products = Product::where($filter . 'category_id', $category_id)->paginate($this->pagesize);
        }

        $categories = Category::all();
        return view('livewire.category-component', compact('products', 'categories', 'category_name'))->layout('layouts.base');
        //return view('livewire.category-component', [
        //    'products' => $products,
        //    'categories' => $categories,
        //    'category_name' => $category_name,
        //])->layout('layouts.base');
    }
}
