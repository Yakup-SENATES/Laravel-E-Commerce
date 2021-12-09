<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminEditCategoryComponent extends Component
{
    public $category_slug, $category_id, $name, $slug;

    /**
     * Program çalıştırılınca çalışacak fonksiyon
     * The function that is run when the program is run
     *
     * @param  mixed $category_slug
     * @return void
     */
    public function mount($category_slug)
    {
        $this->category_slug = $category_slug;
        $category = Category::where('slug', $category_slug)->first();
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
    }

    /**
     * This metod is for create a slug
     * bu metod slug oluşturmak için kullanılır. 
     *
     * @return void
     */
    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:categories',
        ]);
    }

    /**
     * Updates the category
     * Kategori güncellenir
     *
     * @return void
     */
    public function updateCategory()
    {
        $this->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:categories',
        ]);

        $category = Category::find($this->category_id);
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->save();
        session()->flash('message', 'Kategori güncellendi');
    }


    /**
     * Render the component view
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.admin-edit-category-component')->layout('layouts.base');
    }
}
