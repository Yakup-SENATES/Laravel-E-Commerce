<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProductAttribute;
use Attribute;
use Livewire\Component;

class AdminEditAttributeComponent extends Component
{
    public $name, $attribute_id;


    /**
     * The livewire lifecycle method that is run when the component is mounted
     * 
     * @param  mixed $attribute_id
     * @return void
     */
    public function mount($attribute_id)
    {
        $pattribute =  ProductAttribute::find($attribute_id);

        $this->attribute_id = $pattribute->id;
        $this->name = $pattribute->name;
    }


    /**
     * The Livewire lifecycle method that is run when the component is updated
     *
     * @param  mixed $fields
     * @return void
     */
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|min:3|max:255',
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function updateAttribute()
    {
        $this->validate([
            'name' => 'required|min:3|max:255',
        ]);

        $pattribute = ProductAttribute::find($this->attribute_id);
        $pattribute->name = $this->name;
        $pattribute->save();
        session()->flash('success', 'Attribute has been updated');
    }



    /**
     * Render The View
     *
     * @return void
     */
    public function render()
    {

        return view('livewire.admin.admin-edit-attribute-component')->layout('layouts.admin');
    }
}
