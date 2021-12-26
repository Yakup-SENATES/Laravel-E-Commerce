<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminEditCategoryComponent extends Component
{
    public $category_slug, $category_id, $name, $slug, $scategory_id, $scategory_slug;

    /**
     * Program çalıştırılınca çalışacak fonksiyon
     * The function that is run when the program is run
     * $scategory_slug opsiyonel olduğundan default olarak null atıyoruz.  
     * @param  mixed $category_slug
     * @return void
     */
    public function mount($category_slug, $scategory_slug = null)
    {


        //Eğer Sub Category Düzenlenmek isteniyorsa edit sayfasında ona göre bilgiler yazılsın 
        //aksi takdirde ana kategori bilgileri yazılsın

        if ($scategory_slug) {
            $this->scategory_slug = $scategory_slug;
            $scategory = Subcategory::whereSlug($scategory_slug)->first();
            $this->scategory_id = $scategory->id;
            $this->category_id = $scategory->category_id;
            $this->name = $scategory->name;
            $this->slug = $scategory->slug;
        } else {
            $this->category_slug = $category_slug;
            $category = Category::where('slug', $category_slug)->first();
            $this->category_id = $category->id;
            $this->name = $category->name;
            $this->slug = $category->slug;
        }
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

        if ($this->scategory_id) {

            $scategory = Subcategory::find($this->scategory_id);
            $scategory->name = $this->name;
            $scategory->slug = $this->slug;
            $scategory->category_id = $this->category_id;
            $scategory->save();
        } else {

            $category = Category::find($this->category_id);
            $category->name = $this->name;
            $category->slug = $this->slug;
            $category->save();
        }
        session()->flash('message', 'Kategori güncellendi');
    }


    /**
     * Render the component view
     *
     * @return void
     */
    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-edit-category-component', compact('categories'))->layout('layouts.base');
    }
}
