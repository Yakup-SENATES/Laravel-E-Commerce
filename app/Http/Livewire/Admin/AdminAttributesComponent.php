<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProductAttribute;
use Livewire\Component;

class AdminAttributesComponent extends Component
{

    /**
     * Delete The specified resource from storage.
     *
     * @param  mixed $attribute_id
     * @return void
     */
    public function deleteAttribute($attribute_id)
    {
        $pattribute = ProductAttribute::find($attribute_id);
        $pattribute->delete();
        session()->flash('message', 'Attribute has been deleted');
    }


    /**
     * Render The Livewire view Component
     *
     * @return void
     */
    public function render()
    {
        $attributes = ProductAttribute::paginate(10);
        return view('livewire.admin.admin-attributes-component', compact('attributes'))->layout('layouts.admin');
    }
}
