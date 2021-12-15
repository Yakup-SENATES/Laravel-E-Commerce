<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserChangePasswordComponent extends Component
{
    public $oldPassword, $newPassword, $confirmPassword;

    /**
     * updated
     *
     * @param  mixed $fields
     * @return void
     */
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|different:oldPassword',
        ]);
    }

    /**
     * Change Password
     *
     * @return void
     */
    public function changePassword()
    {

        $this->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|different:oldPassword',
        ]);

        if (Hash::check($this->oldPassword, auth()->user()->password)) {

            $user = User::findOrFail(auth()->user()->id);
            $user->password = Hash::make($this->newPassword);
            $user->save();

            session()->flash('password_success', 'Password changed successfully');
        } else {
            session()->flash('password_error', 'Password does not match');
        }
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.user.user-change-password-component')->layout('layouts.base');
    }
}
