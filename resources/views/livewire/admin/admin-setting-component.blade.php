<div>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Settings
                    </div>
                    <div class="panel-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <form class="form-horizontal" wire:submit.prevent="saveSettings">
                            <div class="form-group">
                              <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-4">
                                  <input type="email" class="form-control input-md" placeholder="Email" wire:model="email">
                                  @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label">Phone</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Phone" wire:model="phone">
                                  @error('phone')
                                  <p class="text-danger">{{$message}}</p>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label">Phone2</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Phone2" wire:model="phone2">
                                  @error('phone2')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-4 control-label">Address</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Address" wire:model="address">
                                  @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-4 control-label">Map</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Map" wire:model="map">
                                  @error('map')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>
                            

                            <div class="form-group">
                              <label class="col-md-4 control-label">Twitter</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Twitter" wire:model="twitter">
                                  @error('twitter')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>
                           
                            <div class="form-group">
                              <label class="col-md-4 control-label">Facebook</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Facebook" wire:model="facebook">
                                  @error('facebook')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-4 control-label">Pinterest</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Pinterest" wire:model="pinterest">
                                  @error('pinterest')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-4 control-label">Linkedin</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Linkedin" wire:model="linkedin">
                                  @error('linkedin')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 control-label">Youtube</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Youtube" wire:model="youtube">
                                  @error('youtube')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 control-label">Github</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control input-md" placeholder="Github" wire:model="github">
                                  @error('github')
                                    <p class="text-danger">{{$message}}</p>
                                  @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
