<div>
    <style>
        nav svg{
            height: 20px
        }
        nav .hidden{
            display: block !important;
        }
    </style>

        <div class="container" style="padding:30px 0;">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="row">
                              <div class="col-md-6">All Products</div>
                              <div class="col-md-6">
                                  <a href="{{ route('admin.categories.add') }}" class="btn btn-success pull-right">Add New</a>
                              </div>
                          </div>
                        </div>     
                        <div class="panel-body">
                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>                                
                            @endif
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                        <tr>
                                            <td scope="row">{{$product->id}}</td>
                                            <td><img src="{{asset('assets/images/products')}}/{{$product->image}}" alt="{{$product->image}}" width="60"></td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->stock_status}}</td>
                                            <td>{{$product->regular_price}}</td>
                                            <td>{{$product->getCategory->name}}</td>
                                            <td>{{$product->created_at}}</td>
                                            <td></td>
                                            <td>                                        
                                                {{--<a href="{{ route('admin.categories.edit', ['product_slug'=>$product->slug]) }}"><i class="fa fa-edit fa-2x"></i></a>                                              
                                                <a href="#" wire:click.prevent="deleteProduct({{$product->id}})" style="margin-left:10px"><i class="fa fa-trash fa-2x text-danger justify-end"></i>
                                                </a>
                                         --}}
                                            </td>
                                        </tr>                               
                                        @endforeach
                                    </tbody>
                            </table>
                            {{$products->links()}}
                        </div>
                    </div>                
                </div>
            </div>
        </div>


</div>
