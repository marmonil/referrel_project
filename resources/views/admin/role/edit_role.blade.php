@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Update Role</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('update.role') }}"method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for=""class="form-label">Role name</label>
                            <input type="hidden"name="role_id"class="form-label"value="{{ $role->id }}">
                            <input type="text"name="role_name"class="form-label"value="{{ $role->name }}">

                        </div>
                        <div class="mb-3">
                            <label for=""class="form-label">Permisions</label>
                            <br>
                            @foreach ($all_permisions as $permission)
                                <input type="checkbox" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                    value="{{ $permission->id }}" name="permission[]">
                                {{ $permission->name }}
                                <br>
                            @endforeach




                        </div>
                        <div class="mb-3">
                            <button type="submit"class="btn btn-primary">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
