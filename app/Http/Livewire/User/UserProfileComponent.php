<?php

namespace App\Http\Livewire\User;

use App\Models\Profile;
use App\Models\User;
use Livewire\Component;

class UserProfileComponent extends Component
{
    public function render()
    {
        $userProfile = Profile::where('user_id', auth()->user()->id)->first();
        if (!$userProfile) {
            $profile = new Profile();
            $profile->user_id = auth()->user()->id;
            $profile->save();
        }

        $user = User::find(auth()->user()->id);
        return view('livewire.user.user-profile-component', compact('user'))->layout('layouts.base');
    }
}
