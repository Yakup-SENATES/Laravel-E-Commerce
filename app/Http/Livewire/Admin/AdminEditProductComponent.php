<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class AdminEditProductComponent extends Component
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
        $category_id,
        $newImage,
        $product_id;


    /**
     * Mount the component
     *
     * @param  mixed $product_slug
     * @return void
     */
    public function mount($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $this->product_id = $product->id;
        $this->slug = $product->slug;
        $this->name = $product->name;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->regular_price = $product->regular_price;
        $this->sale_price = $product->sale_price;
        $this->SKU = $product->SKU;
        $this->stock_status = $product->stock_status;
        $this->featured = $product->featured;
        $this->quantity = $product->quantity;
        $this->image = $product->image;
        $this->category_id = $product->category_id;
        $this->product_id = $product->id;
    }

    /**
     * Generate a unique slug for product
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
            'newImage' => 'required|mimes:jpeg,png,jpg',
            'category_id' => 'required',
        ]);
    }

    /**
     * Update the product
     *
     * @return void
     */
    public function updateProduct()
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
            //'image' => 'required|mimes:jpeg,png,jpg',
            'category_id' => 'required',
        ]);



        $product = Product::find($this->product_id);

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
        if ($this->newImage) {
            $imageName = Carbon::now()->timestamp . '.' . $this->newImage->extension();
            $this->image->storeAs('products', $imageName);
            $product->image = $newImage;
        }
        $product->category_id = $this->category_id;
        $product->save();
        session()->flash('message', 'Product has been updated successfully');
    }


    /**
     * Render the component
     *
     * @return void
     */
    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-edit-product-component', [
            'categories' => $categories,
        ])->layout('layouts.base');
    }
}
