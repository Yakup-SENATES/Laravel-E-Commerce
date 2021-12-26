<div>
    <style>
        nav svg{
            height: 20px
        }
        nav.hidden{
            display: block !important;
        }
        .sclist{
            list-style: none;
        }
    </style>

        <div class="container" style="padding:30px 0;">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="row">
                              <div class="col-md-6">All Categories                                  
                              </div>
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
                                        <th>Category Name</th>
                                        <th>Slug</th>
                                        <th>Sub Category</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)                                            
                                        <tr>
                                            <td scope="row">{{$category->id}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->slug}}</td>
                                            <td>
                                                <ul class="sclist">
                                                    @foreach ($category->subcategories as $s_category)
                                                        <li>
                                                            <i class="fa fa-caret-right"></i> {{$s_category->name}} 
                                                            <a href="{{ route('admin.categories.edit', ['category_slug'=>$category->slug,'scategory_slug'=>$s_category->slug]) }}">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>                                        
                                                <a href="{{ route('admin.categories.edit', ['category_slug'=>$category->slug]) }}"><i class="fa fa-edit fa-2x"></i></a>                                              
                                                <a href="#" onclick="confirm('Are You Sure, You Wnat To Delete This Category?')|| event.stopImmediatePropagation()"  wire:click.prevent="deleteCategory({{$category->id}})" style="margin-left:10px"><i class="fa fa-trash fa-2x text-danger justify-end"></i>
                                                </a>
                                         
                                            </td>
                                        </tr>                                
                                        @endforeach
                                    </tbody>
                            </table>
                            {{$categories->links()}}
                        </div>
                    </div>                
                </div>
            </div>
        </div>


</div>
