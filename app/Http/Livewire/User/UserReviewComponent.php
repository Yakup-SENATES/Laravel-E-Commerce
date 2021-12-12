<?php

namespace App\Http\Livewire\User;

use App\Models\OrderItem;
use App\Models\Review;
use Livewire\Component;

class UserReviewComponent extends Component
{
    public $order_item_id, $rating, $comment;


    /**
     * Mount the component
     *
     * @param  mixed $order_item_id
     * @return void
     */
    public function mount($order_item_id)
    {
        $this->order_item_id = $order_item_id;
    }


    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:255',
        ]);
    }


    /**
     * Add review
     *
     * @return void
     */
    public function addReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:255',
        ]);

        $review = new Review();
        $review->rating = $this->rating;
        $review->comment = $this->comment;
        $review->order_item_id = $this->order_item_id;
        $review->save();
        $order_item = OrderItem::find($this->order_item_id);
        $order_item->rstatus = true;
        $order_item->save();
        session()->flash('success', 'Review added successfully');
    }




    /**
     * Render the component
     *
     * @return void
     */
    public function render()
    {
        $order_item = OrderItem::find($this->order_item_id);

        return view('livewire.user.user-review-component', compact('order_item'))->layout('layouts.base');
    }
}
