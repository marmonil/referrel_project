@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Color & Size </a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Color list</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>sl</th>
                            <th>color name</th>
                            <th>color</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($colors as $key => $color)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $color->color_name }}</td>
                                <td><button class="p-2" style="background-color:{{ $color->color_code }}"></button></td>
                                <td>
                                    <a href="" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add colors</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('add.color') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="color_name" class="form-control" placeholder="color name">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="color_code" class="form-control" placeholder="color code">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Size list</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>sl</th>
                            <th>size name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($sizes as $key => $size)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $size->size_name }}</td>
                                <td>
                                    <a href="" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white">Add Size</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('add.size') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="size_name" class="form-control" placeholder="size name">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary ">Add Size</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
