<div class="container" style="padding: 30px 0;">
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Update Profile
                </div>

                <div class="panel-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>                        
                    @endif
                    <a href="{{ route('user.profile') }}" class="btn btn-success pull-right">
                        <i class="fa fa-caret-left" style="margin-right:7px"></i>Back</a>

                    <form action="" wire:submit.prevent="updateProfile">
                        <div class="col-md-4">
                            @if ($newImage)
                                <img src="{{ $newImage->temporaryUrl() }}" width="100%" class="img-responsive img-thumbnail">
                                @elseif($image)
                                <img src="{{asset('assets/images/profile/'.$image)}}" width="100%" class="img-responsive img-thumbnail">
                                @else
                                <img src="{{asset('assets/images/profile/default-profile.jpg')}}" width="100%" class="img-responsive img-thumbnail">
                            @endif
                            <input type="file" class="form-conrol"  wire:model="newImage">

                        </div>
                        <div class="col-md-8">
                            <p><b>Name: </b><input type="text" class="form-control" wire:model="name"> </p>
                            <p><b>Email: </b>{{$email}} </p>
                            <p><b>Phone: </b><input type="text" class="form-control"  wire:model="mobile"> </p>
                            <hr>
                            <p><b>Line1: </b><input type="text" class="form-control"  wire:model="line1">  </p>
                            <p><b>Line2: </b><input type="text" class="form-control"  wire:model="line2">  </p>
                            <p><b>City:  </b><input type="text" class="form-control"  wire:model="city"> </p>
                            <p><b>Province: </b><input type="text" class="form-control"  wire:model="province"> </p>
                            <p><b>Country: </b><input type="text" class="form-control"  wire:model="country">  </p>
                            <p><b>Zip Code: </b><input type="text" class="form-control"  wire:model="zipcode"> </p>
                            <button type="submit" class="btn btn-info pull-right">Update</button>
                        </div>
                  </form>
                </div>
            </div>

        </div>        
    </div>

</div>