<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    /**
     * Its a one to many relationship.
     * The category_id is the foreign key.
     * And the id is the primary key.
     * Get the category that owns the product.
     *
     * @return void
     */
    public function category()
    {
        return  $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Order has many OrderItems
     *
     * @return void
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    /**
     * Its a one to many relationship.
     * The subcategory_id is the foreign key.
     *
     * @return void
     */
    public function subCategories()
    {
        return  $this->belongsTo(Category::class, 'subcategory_id');
    }
}
