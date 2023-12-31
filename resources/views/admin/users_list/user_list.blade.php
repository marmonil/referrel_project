@extends('layouts.dashboard')
@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">user</a></li>
    </ol>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h1>users list ({{ $total_user}})</h1>
                </div>

                <div class="card-body">
                    @if(session('delete'))
                    <div class="alert alert-success">{{session('delete')}}</div>
                    @endif

                    <table class="table table-striped">
                        <tr>
                            <th>sl</th>
                            <th>photo</th>
                            <th>user name</th>
                            <th>email</th>
                            <th>Action</th>
                        </tr>
                        @foreach($users as $key => $user )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                @if($user->profile_photo == null)
                                <img width="50px" src="{{ Avatar::create($user->name)->toBase64() }}" />
                                @else
                                <img width="50px" src="{{ asset('uploads/user') }}/{{$user->profile_photo}}" />
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>

                                <a href=" {{Route('del.user',$user->id)}}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection