<div>
    <div class="container" style="padding: 30px 0;" >
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Add New Coupon
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.coupons') }}" class="btn btn-success pull-right">All Coupons</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{Session::get('message')}}
                        </div>
                            
                        @endif
                        <form action="" class="form-horizontal" wire:submit.prevent="store">
                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Coupon code</label>
                                    <div class="col-md-4">
                                     <input type="text" placeholder="Coupon Code" class="form-control input-md" wire:model="code"> 
                                        @error('code')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Coupon type</label>
                                    <div class="col-md-4">
                                        <select class="form-control" wire:model="type"> 
                                            <option value="">Selected</option>
                                            <option value="fixed">Fixed</option>
                                            <option value="percent">Percent</option>
                                        </select>
                                        @error('type')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Coupon Value</label>
                                    <div class="col-md-4">
                                    <input type="text" placeholder="Coupon Value" class="form-control input-md" wire:model="value"> 
                                    @error('value')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Cart Value</label>
                                    <div class="col-md-4">
                                    <input type="text" placeholder="Cart Value" class="form-control input-md" wire:model="cart_value"> 
                                    @error('cart_value')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Expiry Date</label>
                                    <div class="col-md-4" wire:ignore>
                                    <input type="text" id="expiry_date" placeholder="Expiry Date" class="form-control input-md" wire:model="expiry_date"> 
                                    @error('expiry_date')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-4 control-label"></label>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js" integrity="sha512-PDFb+YK2iaqtG4XelS5upP1/tFSmLUVJ/BVL8ToREQjsuXC5tyqEfAQV7Ca7s8b7RLHptOmTJak9jxlA2H9xQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
<script>
    $(function () {
        $('#expiry_date').datetimepicker({
            format: 'YYYY-MM-DD',
                       useCurrent: false,
                showTodayButton: true,
                showClear: true,
                toolbarPlacement: 'bottom',
                sideBySide: true,
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
                    previous: "fa fa-chevron-left",
                    next: "fa fa-chevron-right",
                    today: "fa fa-clock-o",
                    clear: "fa fa-trash-o"
    }         
        }).on('dp.change', function (ev) {
            var data  = $('#expiry_date').val();
            @this.set('expiry_date', data);
        });
 });
</script>

@endpush