<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminAddCategoryComponent extends Component
{
    public $name, $slug;

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store()
    {
        $this->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:categories',
        ]);

        $category = new Category();
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->save();
        session()->flash('message', 'Category has been created Successfully');
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:categories',
        ]);
    }


    /**
     * Generate slug from name
     *
     * @return void
     */
    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function render()
    {
<<<<<<< main

        return view('livewire.admin.admin-add-category-component')->layout('layouts.base');
=======
        $categories = Category::all();
        return view('livewire.admin.admin-add-category-component', compact('categories'))->layout('layouts.admin');
>>>>>>> local
    }
}
