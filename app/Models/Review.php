<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';

    /**
     * Relation with OrderItem
     *
     * @return void
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
