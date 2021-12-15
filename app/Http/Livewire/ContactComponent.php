<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;

class ContactComponent extends Component
{
    public $name, $email, $phone, $comment;


    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'comment' => 'required',
        ]);
    }



    public function saveMessage()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'comment' => 'required',
        ]);
        $message = new Contact();
        $message->name = $this->name;
        $message->email = $this->email;
        $message->phone = $this->phone;
        $message->comment = $this->comment;
        $message->save();
        session()->flash('message', 'Thanks. Your Message has been sent Successfully! ');
    }



    public function render()
    {
        return view('livewire.contact-component')->layout('layouts.base');
    }
}
