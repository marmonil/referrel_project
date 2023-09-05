@extends('layouts.dashboard')
@section('content')

<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category </a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)"> edit Category </a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            @if(session('update'))
            <div class="alert alert-success">{{session('update')}}
            </div>
            @endif
            <div class="card-header bg-primary">
                <h class="text-white" 3>Edit Category</h>
            </div>
            <div class="card-body">
                <form action="{{route('category.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="hidden" value="{{$category_info->id}}" name="category_id">
                        <input type="text" class="form-control" value="{{$category_info->category_name}}" name="category_name">


                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category image</label>
                        <input type="file" value="{{$category_info->category_image}}" class="form-control" name="category_image" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img src="{{ asset('uploads/cetegory') }}/{{ $category_info->category_image}}" id="blah" alt="" width="200px">

                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary"> Edit Category</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection