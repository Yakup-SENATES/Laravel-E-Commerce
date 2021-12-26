<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminAddCategoryComponent extends Component
{
    public $name, $slug, $category_id;

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

        //parent category varsa ona altında yoksa kendi başlığıyla category açar

        if ($this->category_id) {

            $s_category = new Subcategory();
            $s_category->name = $this->name;
            $s_category->slug = $this->slug;
            $s_category->category_id = $this->category_id;
            $s_category->save();
        } else {

            $category = new Category();
            $category->name = $this->name;
            $category->slug = $this->slug;
            $category->save();
        }

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
        $categories = Category::all();
        return view('livewire.admin.admin-add-category-component', compact('categories'))->layout('layouts.base');
    }
}
