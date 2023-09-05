@extends('frontend.master')
@section('content')
    <!-- breadcrumb_section - start
                                                                    ================================================== -->
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="index.html">Home</a></li>
                <li>Cart</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end
                                                            ==================================================
                                                            -->
    <div class="container">
        <div class="row">
            @if (session('pass_reset'))
                <div class="alert alert-success">{{ session('pass_reset') }}</div>
            @endif
            <div class="col-lg-6 m-auto my-5">
                <div class="card">
                    <div class="card-header">
                        <h3>Password reset request</h3>
                    </div>
                    <div class="card-body bg-secondary">
                        <form action="{{ route('pass.reset.req.send') }}"method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for=""class="form-control">Email Address</label>
                                <input type="email"class="form-control"name="email">
                            </div>
                            <div class="mb-3">
                                <button type="submit"class="form-control btn btn-primary">submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
