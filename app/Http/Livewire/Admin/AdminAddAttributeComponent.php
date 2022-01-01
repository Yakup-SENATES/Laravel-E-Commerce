<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProductAttribute;
use Livewire\Component;

class AdminAddAttributeComponent extends Component
{
    public $name;


    /**
     * Formda güncelleme yapasak doğrulama yapıyor.
     * When the form is updated, validation is performed.
     *
     * @param  mixed $fields
     * @return void
     */
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string|max:255',
        ]);
    }


    /**
     * Add Attribute
     *
     * @return void
     */
    public function addAttribute()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute = new ProductAttribute();
        $attribute->name = $this->name;
        $attribute->save();

        $this->name = '';
        session()->flash('success', 'Attribute added successfully');
    }

    /**
     * Render the component.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.admin-add-attribute-component')->layout('layouts.admin');
    }
}
