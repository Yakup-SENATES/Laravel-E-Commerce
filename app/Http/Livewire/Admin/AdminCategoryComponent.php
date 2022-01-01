<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryComponent extends Component
{
    use WithPagination;

    /**
     * Delete Category by id
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        session()->flash('message', 'Category Deleted Successfully');
    }

    public function render()
    {
        $categories  = Category::paginate(5);
        return view('livewire.admin.admin-category-component', [
            'categories' => $categories
        ])->layout('layouts.admin');
    }
}
