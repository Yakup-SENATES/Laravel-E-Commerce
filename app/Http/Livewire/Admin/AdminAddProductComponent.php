<?php

namespace App\Http\Livewire\Admin;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
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
        $category_id,
        $images, $scategory_id,
        $attr, $inputs = [], $attribute_arr = [], $attribute_values;


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
     * kullanıcının seçtiği attribute başlığı $attr elemanına atanır. 
     * $attr elemanı $attribute_arr dizisinde yoksa 
     * array_push metoduyla bu $attr elemanı önce inputs dizisine atanır
     * sonra attribute_arr metoduna da atanır .
     * inputs dizisi seçilen attribute ismini yeni açılacak
     *  HTML-input alanında hangi alan hangi attribute e ait olacak 
     * anlaşılması için kullanıldı.
     * açılan HTML-Input alanının içine yazılan Attibute specific değeri 
     *$attribute_values elemanına verilir böylece kayıt işlemi bu değer ile yapılır
     *
     * @return void
     */
    public function addAttribute()
    {
        if (!in_array($this->attr, $this->attribute_arr)) {

            array_push($this->inputs, $this->attr);
            array_push($this->attribute_arr, $this->attr);
        }
    }


    /**
     * Remove The Attribute 
     *
     * @param  mixed $attr
     * @return void
     */
    public function removeAttr($attr)
    {
        unset($this->inputs[$attr]);
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

        if ($this->images) {

            $imagesName = '';

            foreach ($this->images as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key . '.' . $image->extension();
                $image->storeAs('products', $imgName);
                $imagesName = $imagesName . ',' . $imgName;
            }
            $product->images = $imagesName;
        }

        $product->category_id = $this->category_id;

        //eğer kategori alt kategorisi varsa kategori alt kategorisi idsini kaydet

        if ($this->scategory_id) {
            $product->subcategory_id = $this->scategory_id;
        }
        $product->save();

        //Attribute kaydedilen alan

        foreach ($this->attribute_values as $key => $attribute_value) {

            $avalues = explode(",", $attribute_value);

            foreach ($avalues as $avalue) {

                $attr_value = new AttributeValue();
                $attr_value->product_attribute_id = $key;
                $attr_value->value = $avalue;
                $attr_value->product_id =  $product->id;
                $attr_value->save();
            }
        }

        session()->flash('message', 'Product added successfully');
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
     * Render the view.
     *
     * @return void
     */
    public function render()
    {
        $scategories = Subcategory::where('category_id', $this->category_id)->get();
        $categories = Category::all();

        $pattributes = ProductAttribute::all();

        return view('livewire.admin.admin-add-product-component', compact('categories', 'scategories', 'pattributes'))->layout('layouts.base');
    }
}
