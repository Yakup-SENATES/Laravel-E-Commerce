<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    public function render()
    {
        $porducts = Product::paginate(12);
        return view('livewire.shop-component', [
            'products' => $porducts,
        ])->layout('layouts.base');
    }
}
