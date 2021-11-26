<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coupon;
use Livewire\Component;

class AdminCouponsComponent extends Component
{

    /**
     * Delete 
     *
     * @param  mixed $coupon_id
     * @return void
     */
    public function deleteCoupon($coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        session()->flash('message', 'Coupon has been deleted successfully');
    }


    /**
     * Render the view
     *
     * @return void
     */
    public function render()
    {
        $coupons = Coupon::all();
        return view('livewire.admin.admin-coupons-component', compact('coupons'))->layout('layouts.base');
    }
}
