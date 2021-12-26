<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductComponent extends Component
{
    use WithPagination;

    /**
     * Delete product
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        $product = Product::find($id);

        if ($product->image) {
            unlink('assets/images/products' . '/' . $product->image);
        }

        if ($product->images) {
            $images = explode(",", $product->images);
            foreach ($images as $image) {
                if ($image) {
                    unlink('assets/images/products' . '/' . $image);
                }
            }
        }

        $product->delete();
        session()->flash('message', 'Product deleted successfully');
    }


    /**
     * Render the component view
     *
     * @return void
     */
    public function render()
    {
        $products = Product::paginate(10);
        return view('livewire.admin.admin-product-component', compact('products'))->layout('layouts.base');
    }
}
