<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class AdminSettingComponent extends Component
{
    public $email,
        $phone,
        $phone2,
        $address,
        $facebook,
        $twitter,
        $github,
        $youtube,
        $linkedin,
        $pinterest,
        $map;


    /**
     * The life cycle method.
     *
     * @return void
     */
    public function mount()
    {
        $setting = Setting::find(1);
        if ($setting) {
            $this->email = $setting->email;
            $this->phone = $setting->phone;
            $this->phone2 = $setting->phone2;
            $this->address = $setting->address;
            $this->facebook = $setting->facebook;
            $this->twitter = $setting->twitter;
            $this->github = $setting->github;
            $this->youtube = $setting->youtube;
            $this->linkedin = $setting->linkedin;
            $this->pinterest = $setting->pinterest;
            $this->map = $setting->map;
        }
    }

    /**
     * The lifecycle method of livewire.
     *
     * @param  mixed $fields
     * @return void
     */
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'phone2' => 'required|numeric',
            'address' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'github' => 'required',
            'youtube' => 'required',
            'linkedin' => 'required',
            'pinterest' => 'required',
            'map' => 'required',
        ]);
    }


    /**
     * Save The Setting
     *
     * @return void
     */
    public function saveSettings()
    {
        $this->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'phone2' => 'required',
            'address' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'github' => 'required',
            'youtube' => 'required',
            'linkedin' => 'required',
            'pinterest' => 'required',
            'map' => 'required',
        ]);

        $setting = Setting::find(1);


        if (!$setting) {
            $setting = new Setting();
        }
        $setting->email = $this->email;
        $setting->phone = $this->phone;
        $setting->phone2 = $this->phone2;
        $setting->address = $this->address;
        $setting->facebook = $this->facebook;
        $setting->twitter = $this->twitter;
        $setting->github = $this->github;
        $setting->youtube = $this->youtube;
        $setting->linkedin = $this->linkedin;
        $setting->pinterest = $this->pinterest;
        $setting->map = $this->map;
        $setting->save();
        session()->flash('success', 'Setting Updated Successfully');
    }



    /**
     * Render the component's view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.admin-setting-component')->layout('layouts.base');
    }
}
