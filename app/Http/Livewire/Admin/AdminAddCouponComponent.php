<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coupon;
use Livewire\Component;

class AdminAddCouponComponent extends Component
{
    public $code, $type, $value, $cart_value;


    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required',
        ]);
    }

    public function store()
    {
        $this->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required',
        ]);
        $coupon = new Coupon();
        $coupon->code  = $this->code;
        $coupon->type  = $this->type;
        $coupon->value  = $this->value;
        $coupon->cart_value = $this->cart_value;
        $coupon->save();
        session()->flash('message', 'Coupon has been created successfully');
    }
    public function render()
    {
        return view('livewire.admin.admin-add-coupon-component')->layout('layouts.base');
    }
}