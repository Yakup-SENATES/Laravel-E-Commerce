<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserEditProfileComponent extends Component
{
    use WithFileUploads;

    public $name, $email, $mobile, $line1, $line2, $city, $province, $country, $zipcode, $image, $newImage;


    /**
     * The LifeCycle method is called when the component is mounted.
     *
     * @return void
     */
    public function mount()
    {
        $user = User::find(auth()->user()->id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->profile->mobile;
        $this->line1 = $user->profile->line1;
        $this->line2 = $user->profile->line2;
        $this->city = $user->profile->city;
        $this->province = $user->profile->province;
        $this->country = $user->profile->country;
        $this->zipcode = $user->profile->zipcode;
        $this->image = $user->profile->image;
    }

    /**
     * Update the user profile
     *
     * @return void
     */
    public function updateProfile()
    {
        $user = User::find(auth()->user()->id);
        $user->name = $this->name;
        $user->save();
        //user kendi profilini güncelliyor. kalan kısımlar profil tablosuna kaydediliyor.

        $user->profile->mobile = $this->mobile;

        if ($this->newImage) {

            if ($this->image) {
                try {
                    unlink('assets/images/profile/' . $this->image);
                } catch (\Throwable $th) {
                }
                $imageName = Carbon::now()->timestamp . '.' . $this->newImage->extension();
                $this->newImage->storeAs('profile', $imageName);

                $user->profile->image = $imageName;
            }
        }

        $user->profile->line1 = $this->line1;
        $user->profile->line2 = $this->line2;
        $user->profile->city = $this->city;
        $user->profile->province = $this->province;
        $user->profile->country = $this->country;
        $user->profile->zipcode = $this->zipcode;
        $user->profile->save();
        session()->flash('success', 'Profile updated successfully');
    }

    /**
     * Render the view component.
     *
     * @return void
     */
    public function render()
    {
        $user = User::find(auth()->user()->id);
        return view('livewire.user.user-edit-profile-component', compact('user'))->layout('layouts.base');
    }
}
