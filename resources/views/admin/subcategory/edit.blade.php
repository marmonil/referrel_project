@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category </a></li>
    </ol>
</div>
<div class="row">

    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">edit subcategory</h3>

            </div>

            <div class="card-body">
                @if('dsuccess',)
                <form action="{{route('subcategory.update')}}" method="POST">
                    @csrf

                    <input type="hidden" name="subcategory_id" value="{{$subcategory_info->id}}">
                    <div class="mb-3">
                        <select name="category_id" class="form-control">

                            <option value=""> --Select Catagory</option>
                            @foreach($categories as $category)

                            <option value="{{$category->id}}" {{$category->id == $subcategory_info->category_id ? 'selected':''}}> {{$category->category_name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control" value="{{$subcategory_info->subcategory_name}}">
                        @error('subcategory_name')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if(session('exist'))
                        <div class="alert alert-danger">{{session('exist')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Update Subcetegory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection