@extends('layouts.dashboard')
@section('content')
<!-- breadcrumb start -->
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">copun </a></li>
    </ol>
</div>
<!-- breadcrumb end -->
<div class="row">

    <div class="col-lg-8">
        <div class="card">
            @if(session('delete'))
            <div class="alert alert-success"> {{session('delete')}}</div>
            @endif
            <div class="card-header bg-success">
                <h3 class="text-white">Copun list</h3>

            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Copun Name</th>
                        <th>Copun type </th>
                        <th>Valideti</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    @foreach($copuns as $key=>$copun)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$copun->copun_name}}</td>
                        <td>{{($copun->copun_type==1?'solid Amount':'percentage')}}</td>
                        <td>{{$copun->amount}}</td>
                        <td>{{$copun->validity}}</td>
                        <td>
                            <a href="{{route('copun.delete',$copun->id)}}" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                            <a href="#" class="btn btn-danger btn-xs sharp"><i class="fa fa-archive"></i></a>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>


    </div>

    <div class=" col-lg-4">
        <div class="card">
            @if(session('success'))
            <div class="alert alert-success">{{session('success')}}
            </div>
            @endif
            <div class="card-header bg-success">
                <h3 class="text-white" 3>Add Copun</h3>
            </div>
            <div class="card-body">
                <form action="{{Route('copun.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Copun Name</label>
                        <input type="text" class="form-control" name="copun_name">
                        @error('copun_name')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror

                    </div>
                    <div class="mb-3">
                        <select name="copun_type" class="form-control">
                            <option value="">Select type</option>
                            <option value="1">solid amount</option>
                            <option value="2">percentage</option>
                        </select>
                        @error('copun_type')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount">
                        @error('number')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Validity</label>
                        <input type="date" class="form-control" name="validity">
                        @error('validity')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary"> Add Copun</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection