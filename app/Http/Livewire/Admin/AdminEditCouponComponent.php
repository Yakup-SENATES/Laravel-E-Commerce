<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coupon;
use Livewire\Component;

class AdminEditCouponComponent extends Component
{
    public $code, $type, $value, $cart_value, $coupon_id, $expiry_date;


    /**
     * Mount the component
     * Runs when the component is first loaded
     *
     * @param  mixed $coupon_id
     * @return void
     */
    public function mount($coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->cart_value = $coupon->cart_value;
        $this->coupon_id = $coupon->id;
    }
    /**
     * Update 
     * Runs when the component is updated
     *
     * @param  mixed $fields
     * @return void
     */
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'code' => 'required',  //|unique:coupons except eklenmeli 
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required',
            'expiry_date' => 'required',
        ]);
    }

    /**
     * Update coupon
     *
     * @return void
     */
    public function updateCoupon()
    {
        $this->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required',
            'expiry_date' => 'required',
        ]);
        $coupon = Coupon::find($this->coupon_id);
        $coupon->code  = $this->code;
        $coupon->type  = $this->type;
        $coupon->value  = $this->value;
        $coupon->cart_value = $this->cart_value;
        $coupon->expiry_date = $this->expiry_date;
        $coupon->save();
        session()->flash('message', 'Coupon has been updated successfully');
    }

    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.admin-edit-coupon-component')->layout('layouts.base');
    }
}
