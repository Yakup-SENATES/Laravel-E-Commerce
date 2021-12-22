<div>
   <div class="container" style="padding: 30px 0;">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        Add New Product 
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('admin.products')}}" class="btn btn-success pull-right">All Products</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    <strong>Success!</strong> {{ Session::get('message') }}
                </div>
                    
                @endif
                <form wire:submit.prevent="store" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Product Name</label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Product Name" class="form-control input-md" wire:model="name" wire:keyup="generateSlug"/>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Product Slug</label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Product Slug" class="form-control input-md" wire:model="slug"/>
                            @error('slug')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Short Description</label>
                        <div class="col-md-4" wire:ignore>
                            <textarea id="short_description" class="form-control" placeholder="Short Description" wire:model="short_description"></textarea>
                            @error('short_description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Description</label>
                        <div class="col-md-4" wire:ignore>
                            <textarea id="description" class="form-control" placeholder="Description" wire:model="description"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Regular Price</label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Regular Price" class="form-control input-md" wire:model="regular_price"/>
                            @error('regular_price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Sale Price</label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Product Sale" class="form-control input-md" wire:model="sale_price"/>
                            @error('sale_price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">SKU</label>
                        <div class="col-md-4">
                            <input type="text" placeholder="SKU" class="form-control input-md" wire:model="SKU" />
                            @error('SKU')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Stock</label>
                        <div class="col-md-4">
                            <select class="form-control" wire:model="stock_status">
                                <option value="instock">In Stock</option>
                                <option value="outofstock">Out Of Stock</option>
                            </select>
                                @error('stock_status')
                                   <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Fetaured</label>
                        <div class="col-md-4">
                            <select class="form-control" wire:model="featured">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Quantity</label>
                        <div class="col-md-4">
                            <input type="text" placeholder="Quantity" class="form-control input-md" wire:model="quantity"/>
                                @error('quantity')
                                  <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Product Image</label>
                        <div class="col-md-4">
                            <input type="file"class="input-file" wire:model="image"/>
                            @if ($image)
                                <img src="{{$image->temporaryUrl()}}" width="120"/>                                
                            @endif
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                             @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Product Gallery</label>
                        <div class="col-md-4">
                            <input type="file"class="input-file" wire:model="images" multiple />
                                @if ($images)
                                    @foreach ($images as $image)
                                    <img src="{{$image->temporaryUrl()}}" width="120" />                                
                                    @endforeach
                                 @endif
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">Category</label>
                        <div class="col-md-4">
                            <select class="form-control" wire:model="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>                                    
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
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
@push('scripts')
<script>
    $(function () {
   tinymce.init({
       selector: '#short_description',
       setup:function(editor){
           editor.on('Change',function(e){
               tinymce.triggerSave();
               var content_short = $('#short_description').val();
               @this.set('short_description',content_short);
           });
       }  
   });

   tinymce.init({
       selector: '#description',
       setup:function(editor){
           editor.on('Change',function(e){
               tinymce.triggerSave();
               var content_desc = $('#description').val();
               @this.set('description',content_desc);
           });
       }  
   });
});
 </script>
@endpush