@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category </a></li>
    </ol>
</div>

<div class="row">

    <div class="col-lg-8">
        <div class="card">
            @if(session('delete'))
            <div class="alert alert-success"> {{session('delete')}}</div>
            @endif
            <div class="card-header bg-success">
                <h3 class="text-white">Category list</h3>

            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Category image</th>
                        <th>Added by</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($all_categories as $key=>$category)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$category->category_name }}</td>
                        <td><img width="50px" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                        <td>{{$category->rel_to_user->name}}</td>
                        <td>
                            <a href="{{route('category.delete',$category->id)}}" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                            <a href="{{route('category.edit',$category->id)}}" class="btn btn-success btn-xs sharp"><i class="fa fa-pencil"></i></a>

                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <!-- Trash category list -->


        <div class="card">
            @if(session('hard_delete'))
            <div class="alert alert-success"> {{session('hard_delete')}}</div>
            @endif
            @if(session('restrore'))
            <div class="alert alert-success"> {{session('restrore')}}</div>
            @endif
            <div class="card-header bg-success">
                <h3 class="text-white"> Trashed Category list</h3>

            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Category image</th>
                        <th>Added by</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($trashed_categories as $key=>$category)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$category->category_name }}</td>
                        <td><img width="50px" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                        <td>{{$category->rel_to_user->name}}</td>
                        <td>
                            <a href="{{route('category.restore',$category->id)}}" class="btn btn-info btn-xs sharp"></i><i class="fa fa-undo"></i></a>
                            <a href="{{route('category.hard.delete',$category->id)}}" class="btn btn-danger btn-xs sharp"></i><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <!-- trash category end here -->
    </div>

    <div class=" col-lg-4">
        <div class="card">
            @if(session('success'))
            <div class="alert alert-success">{{session('success')}}
            </div>
            @endif
            <div class="card-header bg-success">
                <h3 class="text-white" 3>Add Category</h3>
            </div>
            <div class="card-body">
                <form action="{{Route('category.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name">
                        @error('category_name')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror

                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category image</label>
                        <input type="file" class="form-control" name="category_image">
                        @error('category_image')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary"> Add Category</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>




@endsection