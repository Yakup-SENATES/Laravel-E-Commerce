<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';


    /**
     * Get the user that owns the order.
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
     * Shipping address of the order.
     *
     * @return void
     */
    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    /**
     * Transaction of the order.
     *
     * @return void
     */
    public function transaction()   //transaction is the payment gateway
    {
        return $this->hasOne(Transaction::class);
    }
}
