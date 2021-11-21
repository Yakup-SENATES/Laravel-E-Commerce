<div>

    <div class="container" style="padding:30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sale Setting
                    </div>
                    <div class="panel-body">

                        @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>                            
                        @endif

                        <form class="form-horizontal" wire:submit.prevent="updateSale">
                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Status</label>
                                <div class="col-md-4">
                                    <select  class="form-control" wire:model="status">
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-4 control-label">Sale Date</label>
                                <div class="col-md-4">
                                    <input type="text" id="sale-date" placeholder="YYY/MM/DD H:M:S" class="form-control input-md" wire:model="sale_date">
                                </div>
                            </div>                       
                            <div class="form-group">
                                <label for="" class="col-md-4 control-label"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>                       
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css" integrity="sha512-cOGz9gyEibwgs1MVDCcfmQv6mPyUkfvrV9TsRbTuOA12SQnLzBROihf6/jK57u0YxzlxosBFunSt4V75K6azMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js" integrity="sha512-PDFb+YK2iaqtG4XelS5upP1/tFSmLUVJ/BVL8ToREQjsuXC5tyqEfAQV7Ca7s8b7RLHptOmTJak9jxlA2H9xQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(function(){
            $('#sale-date').datetimepicker({
                format: 'Y-MM-DD h:m:s',
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
            })
            .on('dp.change',function(ev){
                var data = $('#sale-date').val();
                @this.set('sale_date',data);
            })
        })
    </script> 
@endpush