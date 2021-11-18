<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductComponent extends Component
{
    use WithPagination;
    /**
     * Render the component view
     *
     * @return void
     */
    public function render()
    {
        $products = Product::paginate(10);
        //dd($products);
        return view('livewire.admin.admin-product-component', [
            'products' => $products,
        ])->layout('layouts.base');
    }

    /**
     * Delete product
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        session()->flash('message', 'Product deleted successfully');
    }
}
