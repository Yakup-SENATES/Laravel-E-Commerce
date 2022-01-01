<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeSlider;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditHomeSlider extends Component
{
    use WithFileUploads;
    public $title,
        $subtitle,
        $price,
        $link,
        $image,
        $status,
        $newImage,
        $slider_id;


    public function mount($slider_id)
    {
        $slider = HomeSlider::find($slider_id);
        $this->title = $slider->title;
        $this->subtitle = $slider->subtitle;
        $this->price = $slider->price;
        $this->link = $slider->link;
        $this->image = $slider->image;
        $this->status = $slider->status;
        $this->slider_id = $slider_id;
    }

    public function updateSlide()
    {
        $slider = HomeSlider::find($this->slider_id);
        $slider->title = $this->title;
        $slider->subtitle = $this->subtitle;
        $slider->price = $this->price;
        $slider->link = $this->link;
        $slider->status = $this->status;
        if ($this->newImage) {
            $imageName = Carbon::now()->timestamp . '.' . $this->newImage->extension();
            $this->newImage->storeAS('sliders', $imageName);
            $slider->image = $imageName;
        }
        $slider->save();
        session()->flash('message', 'Slider Updated Successfully');
    }

    public function render()
    {
        return view('livewire.admin.admin-edit-home-slider')->layout('layouts.admin');
    }
}
