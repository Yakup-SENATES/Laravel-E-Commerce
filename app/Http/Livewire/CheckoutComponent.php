<?php

namespace App\Http\Livewire;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Cart;
use Exception;
use Illuminate\Support\Facades\Mail;
use Stripe;

class CheckoutComponent extends Component
{
    public $ship_to_different,
        $firstname,
        $lastname,
        $email,
        $mobile,
        $line1,
        $line2,
        $city,
        $province,
        $country,
        $zipcode;

    public $s_firstname,
        $s_lastname,
        $s_email,
        $s_mobile,
        $s_line1,
        $s_line2,
        $s_city,
        $s_province,
        $s_country,
        $s_zipcode;


    public $paymentmode, $thankyou,
        $card_no, $exp_month, $exp_year, $cvc;

    /**
     * Update the component when it is changed.
     *
     * @return void
     */
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'line1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'paymentmode' => 'required',
        ]);
        if ($this->ship_to_different) {
            $this->validateOnly($fields, [
                's_firstname' => 'required',
                's_lastname' => 'required',
                's_email' => 'required|email',
                's_mobile' => 'required|numeric',
                's_line1' => 'required',
                's_city' => 'required',
                's_province' => 'required',
                's_country' => 'required',
                's_zipcode' => 'required',
                'paymentmode' => 'required',
            ]);
        }

        if ($this->paymentmode == 'card') {

            $this->validateOnly($fields, [
                'card_no' => 'required|numeric',
                'exp_month' => 'required|numeric',
                'exp_year' => 'required|numeric',
                'cvc' => 'required|numeric',

            ]);
        }
    }



    /**
     * Place order
     * siparişi yapar tipine göre ödemesni yapar
     * paypal seçildiyse
     * stripe ile ödeme yapar
     *
     * @return void
     */
    public function placeOrder()
    {
        $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'line1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'paymentmode' => 'required',
        ]);


        if ($this->paymentmode == 'card') {

            $this->validate([
                'card_no' => 'required|numeric',
                'exp_month' => 'required|numeric',
                'exp_year' => 'required|numeric',
                'cvc' => 'required|numeric',

            ]);
        }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];

        $order->firstname = $this->firstname;
        $order->lastname = $this->lastname;
        $order->email = $this->email;
        $order->mobile = $this->mobile;
        $order->line1 = $this->line1;
        $order->line2 = $this->line2;
        $order->city = $this->city;
        $order->province = $this->province;
        $order->country = $this->country;
        $order->zipcode = $this->zipcode;
        $order->status = 'ordered';
        $order->is_shipping_different = $this->ship_to_different ? 1 : 0;
        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            $order_item = new OrderItem();
            $order_item->product_id = $item->id;
            $order_item->order_id = $order->id;
            $order_item->price = $item->price;
            $order_item->quantity = $item->qty;
            $order_item->save();
        }

        if ($this->ship_to_different) {

            $this->validate([
                's_firstname' => 'required',
                's_lastname' => 'required',
                's_email' => 'required|email',
                's_mobile' => 'required|numeric',
                's_line1' => 'required',
                's_city' => 'required',
                's_province' => 'required',
                's_country' => 'required',
                's_zipcode' => 'required',
            ]);

            $shipping = new Shipping();
            $shipping->firstname = $this->s_firstname;
            $shipping->lastname = $this->s_lastname;
            $shipping->email = $this->s_email;
            $shipping->mobile = $this->s_mobile;
            $shipping->line1 = $this->s_line1;
            $shipping->line2 = $this->s_line2;
            $shipping->city = $this->s_city;
            $shipping->province = $this->s_province;
            $shipping->country = $this->s_country;
            $shipping->zipcode = $this->s_zipcode;
            $shipping->order_id = $order->id;
            $shipping->save();
        }

        if ($this->paymentmode == 'cod') {
            $this->makeTransaction($order->id, 'pending');
            $this->resetCart();
        } else if ($this->paymentmode == 'card') {

            $stripe = Stripe::make(env('STRIPE_KEY'));
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $this->card_no,
                        'exp_month' => $this->exp_month,
                        'exp_year' => $this->exp_year,
                        'cvc' => $this->cvc,
                    ]
                ]);
                if (!isset($token['id'])) {
                    session()->flash('stripe_error', 'The stripe token was not generated correctly!');
                    $this->thankyou = 0;
                }

                $customer = $stripe->customers()->create([
                    'name' => $this->firstname . ' ' . $this->lastname,
                    'email' => $this->email,
                    'phone' => $this->mobile,
                    'address' => [
                        'line1' => $this->line1,
                        'postal_code' => $this->zipcode,
                        'city' => $this->city,
                        'state' => $this->province,
                        'country' => $this->country,
                    ],
                    'shipping' => [
                        'name' => $this->firstname . ' ' . $this->lastname,
                        'address' => [
                            'line1' => $this->line1,
                            'postal_code' => $this->zipcode,
                            'city' => $this->city,
                            'state' => $this->province,
                            'country' => $this->country,
                        ],
                    ],
                    'source' => $token['id']
                ]);

                $charge  = $stripe->charges()->create([
                    'customer' => $customer['id'],
                    'currency' => 'USD',
                    'amount' => session()->get('checkout')['total'],
                    'description' => 'Payment for order no ' . $order->id

                ]);

                if ($charge['status'] == 'succeeded') {
                    $this->makeTransaction($order->id, 'approved');
                    $this->resetCart();
                } else {
                    session()->flash('stripe_error', 'Error in Transaction');
                    $this->thankyou = 0;
                }
            } catch (Exception $e) {
                session()->flash('stripe_error', $e->getMessage());
                $this->thankyou = 0;
            }
        }
        $this->sendOrderConfirmationMail($order);
    }


    /**
     * Reset Cart
     *
     * @return void
     */
    public function resetCart()
    {
        $this->thankyou = 1;

        Cart::instance('cart')->destroy();

        session()->forget('checkout');
    }



    /**
     * Make the transaction
     * T
     *
     * @param  mixed $order_id
     * @param  mixed $status
     * @return void
     */
    public function makeTransaction($order_id, $status)
    {
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->order_id = $order_id;
        $transaction->mode = $this->paymentmode;
        $transaction->status = $status;
        $transaction->save();
    }


    /**
     * Send Order Confirmation Email
     *
     * @param  mixed $order
     * @return void
     */
    public function sendOrderConfirmationMail($order)
    {
        Mail::to($order->email)->send(new OrderConfirmationMail($order));
    }

    /**
     * Verify user
     *
     * @return void
     */
    public function verifyForCheckout()
    {
        if (!Auth::check()) {

            return redirect()->route('login');
        } elseif ($this->thankyou) {

            return redirect()->route('thankyou');
        } elseif (!session()->has('checkout')) {

            return redirect()->route('cart');
        }
    }



    /**
     * Render the component
     *
     * @return void
     */
    public function render()
    {
        $this->verifyForCheckout();
        return view('livewire.checkout-component')->layout('layouts.base');
    }
}
