<?php

namespace App\Http\Livewire\Admin;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
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
        $product_id,
        $images,
        $newImages, $scategory_id,
        $attr, $inputs = [], $attribute_arr = [], $attribute_values = [];


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
        $this->images = explode(",", $product->images);
        $this->category_id = $product->category_id;
        $this->product_id = $product->id;
        $this->scategory_id = $product->subcategory_id;

        //Attribute Values
        $this->inputs = $product->attributeValues->where('product_id', $product->id)->unique('product_attribute_id')->pluck('product_attribute_id')->toArray();
        $this->attribute_arr = $product->attributeValues->where('product_id', $product->id)->unique('product_attribute_id')->pluck('attribute_id')->toArray();

        foreach ($this->attribute_arr as $a_arr) {

            $allAttributeValue = AttributeValue::where('product_id', $product->id)->where('product_attribute_id', $a_arr)->get()->pluck('value');
            $valueString = '';
            foreach ($allAttributeValue as $value) {
                $valueString .= $value . ',';
            }
            $this->attribute_values[$a_arr] = rtrim($valueString, ',');
        }
    }


    public function addAttribute()
    {
        if (!in_array($this->attr, $this->attribute_arr)) {

            array_push($this->inputs, $this->attr);
            array_push($this->attribute_arr, $this->attr);
        }
    }

    public function removeAttr($attr)
    {
        unset($this->inputs[$attr]);
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
            'name' => 'required',
            'slug' => 'required',
            'short_description' => 'required|min:3',
            'description' => 'required|min:3',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'category_id' => 'required',
        ]);

        if ($this->newImage) {
            $this->validateOnly($fields, [
                'newImage' => 'required|mimes:jpeg,png,jpg',
            ]);
        }
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
            'slug' => 'required|min:3',
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


        if ($this->newImage) {
            $this->validate([
                'newImage' => 'required|mimes:jpeg,png,jpg',
            ]);
        }


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

            unlink('assets/images/products' . '/' . $product->image);
            $imageName = Carbon::now()->timestamp . '.' . $this->newImage->extension();
            $this->newImage->storeAs('products', $imageName);
            $product->image = $newImage;
        }
        if ($this->newImages) {
            if ($product->images) {
                $images = explode(",", $product->images);

                foreach ($images as $image) {
                    if ($image) {
                        unlink('assets/images/products' . '/' . $image);
                    }
                }
            }

            $imagesName = '';
            foreach ($this->newImages as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key .  '.' . $image->extension();
                $image->storeAs('products', $imgName);
                $imagesName = $imagesName . ',' . $imgName;
            }

            $product->images = $imagesName;
        }
        $product->category_id = $this->category_id;

        if ($this->scategory_id) {
            $product->subcategory_id = $this->scategory_id;
        }

        $product->save();

        // Attribute Values Update !!! 
        AttributeValue::where('product_id', $product->id)->delete();
        foreach ($this->attribute_values as $key => $attribute_value) {
            $avalues = explode(",", $attribute_value);

            foreach ($avalues as $avalue) {
                $attr_value = new AttributeValue();
                $attr_value->product_attribute_id = $key;
                $attr_value->value = $avalue;
                $attr_value->product_id = $product->id;
                $attr_value->save();
            }
        }

        session()->flash('message', 'Product has been updated successfully');
    }



    /**
     * Change the Sub Category.
     *
     * @return void
     */
    public function changeSubcategory()
    {
        $this->scategory_id = 0;
    }


    /**
     * Render the component
     *
     * @return void
     */
    public function render()
    {
        $categories = Category::all();
        $scategories = Subcategory::where('category_id', $this->category_id)->get();
        $pattributes = ProductAttribute::all();
        return view('livewire.admin.admin-edit-product-component', compact('categories', 'scategories', 'pattributes'))->layout('layouts.admin');
    }
}
