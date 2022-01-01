<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeSlider;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminAddHomeSliderComponent extends Component
{
    use WithFileUploads;
    public $title,
        $subtitle,
        $price,
        $link,
        $image,
        $status;

    public function mount()
    {
        $this->status = 0;
    }

    public function addSlide()
    {
        $slider = new HomeSlider();
        $slider->title = $this->title;
        $slider->subtitle = $this->subtitle;
        $slider->price = $this->price;
        $slider->link = $this->link;
        $imageName = Carbon::now()->timestamp . '.' . $this->image->extension();
        $this->image->storeAS('sliders', $imageName);
        $slider->image = $imageName;

        $slider->status = $this->status;
        $slider->save();
        session()->flash('message', 'Slide has been created Successfully');
    }


    public function render()
    {
        return view('livewire.admin.admin-add-home-slider-component')->layout('layouts.admin');
    }
}
