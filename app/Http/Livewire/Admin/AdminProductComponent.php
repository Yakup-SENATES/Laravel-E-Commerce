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
<<<<<<< main
        $product = Product::find($id);
        $product->delete();
        session()->flash('message', 'Product deleted successfully');
=======
        $search = '%' . $this->searchTerm . '%';
        $products = Product::where('name', 'LIKE', $search)
            ->orWhere('stock_status', 'LIKE', $search)
            ->orWhere('regular_price', 'LIKE', $search)
            ->orWhere('sale_price', 'LIKE', $search)
            ->orderBy('id', 'DESC')->paginate(10);
        return view('livewire.admin.admin-product-component', compact('products'))->layout('layouts.admin');
>>>>>>> local
    }
}
