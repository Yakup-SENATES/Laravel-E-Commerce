<?php

namespace App\Http\Livewire\Admin;

use App\Models\Contact;
use Livewire\Component;

class AdminContactComponent extends Component
{
    public function render()
    {
        $contacts = Contact::paginate(12);
        return view('livewire.admin.admin-contact-component', compact('contacts'))->layout('layouts.admin');
    }
}
