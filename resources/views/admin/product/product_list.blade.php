@extends('layouts.dashboard')
@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Product </a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="mb-3">
                    Product List
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>category</th>
                        <th>product</th>
                        <th>price</th>
                        <th>discount</th>
                        <th>brand</th>
                        <th>Preview</th>
                        <th>Action</th>
                        <!-- <th>Long Desp</th> -->
                    </tr>
                    @foreach($all_product as $key=>$product)
                    <tr>

                        <td>{{$key+1}}</td>
                        <td>{{$product->rel_to_category->category_name}}</td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->product_price}}</td>
                        <td>{{$product->discount}}</td>
                        <td>{{$product->brand}}</td>
                        <td><img width="50px" src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt=""> </td>
                        <td>
                            <a href="{{route('delete.product')}}" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                            <a href="{{route('inventory',$product->id)}}" class="btn btn-danger btn-xs sharp"><i class="fa fa-archive"></i></a>

                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection