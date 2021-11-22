<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminAddProductComponent extends Component
{
    use WithFileUploads;
    public $slug,
        $name,
        $short_description,
        $description,
        $regular_price,
        $sale_price,
        $SKU,
        $stock_status,
        $featured,
        $quantity,
        $image,
        $category_id;


    /**
     * The mount method is called when the component is first mounted.
     *
     * @return void
     */
    public function mount()
    {
        $this->stock_status = 'instock';
        $this->featured = 0;
    }

    /**
     * Generate a unique slug for the product.
     *
     * @return void
     */
    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|min:3',
            'slug' => 'required|min:3|unique:products',
            'short_description' => 'required|min:3',
            'description' => 'required|min:3',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpeg,png,jpg',
            'category_id' => 'required',
        ]);
    }


    /**
     * store the product in the database.
     *
     * @return void
     */
    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'slug' => 'required|min:3|unique:products',
            'short_description' => 'required|min:3',
            'description' => 'required|min:3',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpeg,png,jpg',
            'category_id' => 'required',
        ]);

        $product  = new Product();
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->regular_price = $this->regular_price;
        $product->sale_price = $this->sale_price;
        $product->SKU = $this->SKU;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;
        $imageName = Carbon::now()->timestamp . '.' . $this->image->extension();
        $this->image->storeAs('products', $imageName);
        $product->image = $imageName;
        $product->category_id = $this->category_id;
        $product->save();
        session()->flash('message', 'Product added successfully');
    }

    /**
     * Render the view.
     *
     * @return void
     */
    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-add-product-component', ['categories' => $categories])->layout('layouts.base');
    }
}
