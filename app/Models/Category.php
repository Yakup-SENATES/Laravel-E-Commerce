<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table =  'categories';

    protected $fillable = ['name', 'slug'];

    /**
     * Get Subcategories
     * alt kategorileri getirir
     *
     * @return void
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }
}
