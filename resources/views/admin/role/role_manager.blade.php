@extends('layouts.dashboard')
@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Role Manager </a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Role list</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>sl</th>
                                <th>Role name</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_roles as $key => $role)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->getAllPermissions() as $permission)
                                            {{ $permission->name }},
                                        @endforeach
                                    </td>
                                    <td><a class="btn btn-info" href="{{ route('edit.role', $role->id) }}">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>User list</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>sl</th>
                                <th>user name</th>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_user as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @forelse ($user->getRoleNames() as $role)
                                            {{ $role }}
                                        @empty
                                            not assignd yet
                                        @endforelse
                                    </td>
                                    <td>
                                        @forelse ($user->getAllPermissions() as $role)
                                            {{ $role->name }},
                                        @empty
                                            Not assigned yet
                                        @endforelse
                                    </td>
                                    <td>
                                        <a class="btn btn-success"href="{{ route('edit.permission', $user->id) }}">Edit</a>
                                        <a class="btn btn-secondary"href="{{ route('remove.role', $user->id) }}">Remove
                                            Role</a>
                                    </td>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Permision</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('add.permision') }}"method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for=""class="form-label">Permision name</label>
                            <input type="text"name="permision_name"class="form-label">
                        </div>
                        <div class="mb-3">
                            <button type="submit"class="btn btn-primary">Add Permision</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Add Role</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('add.role') }}"method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for=""class="form-label">Role name</label>
                            <input type="text"name="role_name"class="form-label">
                        </div>
                        <div class="mb-3">
                            <label for=""class="form-label">Permisions</label>
                            <br>
                            @foreach ($all_permisions as $permision)
                                <input type="checkbox"value="{{ $permision->id }}"name="permision[]">
                                {{ $permision->name }}
                                <br>
                            @endforeach

                        </div>
                        <div class="mb-3">
                            <button type="submit"class="btn btn-primary">Add Role</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Assign Role</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('assign.role') }}"method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="user_id" id=""class="form-control">
                                <option value="">-- Select user --</option>
                                @foreach ($all_user as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="role_id" id=""class="form-control">
                                <option value="">-- Select Role --</option>
                                @foreach ($all_roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit"class="btn btn-primary">Assign Role</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
