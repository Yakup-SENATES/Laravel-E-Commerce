<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\HomeCategory;
use Livewire\Component;

class AdminHomeCategoryComponent extends Component
{
    public $selected_categories = [];
    public $numberOfProduct;

    public function mount()
    {
        $category = HomeCategory::find(1);
        $this->selected_categories = explode(',', $category->sel_categories);
        $this->numberOfProduct = $category->no_of_products;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function updateHomeCategory()
    {
        $category = HomeCategory::find(1);
        // dd($category);
        $category->sel_categories = implode(',', $this->selected_categories);
        $category->no_of_products = $this->numberOfProduct;
        $category->save();
        session()->flash('message', 'Home Category Updated Successfully');
    }


    /**
     * Render the component view
     *
     * @return void
     */
    public function render()
    {
        $categories = Category::all();

        return view('livewire.admin.admin-home-category-component', [
            'categories' => $categories
        ])->layout('layouts.admin');
    }
}
