<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';


    /**
     * Relation with Order
     *
     * @return void
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relation with Product
     *
     * @return void
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relational model of reviews
     *
     * @return void
     */
    public function review()
    {
        return $this->hasOne(Review::class, 'order_item_id');
    }
}
