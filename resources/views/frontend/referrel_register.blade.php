@extends('frontend.master')
@section('content')
    <!-- breadcrumb_section - start
                                                                                                                                                                            ================================================== -->
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="index.html">Home</a></li>
                <li>Login/Register</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end
                                                                                                                                                                            ================================================== -->

    <!-- register_section - start
                                                                                                                                                                            ================================================== -->
    <section class="register_section section_space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if (session('register'))
                        <div class="alert alert-success">{{ session('register') }}</div>
                    @endif
                    @if (session('email_verify'))
                        <div class="alert alert-success">{{ session('email_verify') }}</div>
                    @endif
                    @if (session('pass_reset'))
                        <div class="alert alert-success">{{ session('pass_reset') }}</div>
                    @endif

                    <ul class="nav register_tabnav ul_li_center" role="tablist">

                        <li role="presentation">
                            <button data-bs-toggle="tab" data-bs-target="#signup_tab" type="button" role="tab"
                                aria-controls="signup_tab" aria-selected="false">Register</button>
                        </li>
                    </ul>

                    <div class="register_wrap tab-content">


                        <div class="tab-pane fade" id="signup_tab" role="tabpanel">
                            <form action="{{ route('coustomer.register.store') }}" method="POST">
                                @csrf
                                <div class="form_item_wrap">
                                    <h3 class="input_title"> Name</h3>
                                    <div class="form_item">
                                        <label for="username_input2"><i class="fas fa-user"></i></label>
                                        <input id="username_input2" type="text" name="name" placeholder="Name">
                                        @error('name')
                                            <strong style="color:red">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">Password*</h3>
                                    <div class="form_item">
                                        <label for="password_input2"><i class="fas fa-lock"></i></label>
                                        <input id="password_input2" type="password" name="password" placeholder="Password">
                                        @error('password')
                                            <strong style="color:red">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title"> Confirm Password</h3>
                                    <div class="form_item">
                                        <label for="password_input2"><i class="fas fa-lock"></i></label>
                                        <input id="password_input" type="password" name="password_confirmation"
                                            placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">Email*</h3>
                                    <div class="form_item">
                                        <label for="email_input"><i class="fas fa-envelope"></i></label>
                                        <input id="email_input" type="email" name="email" placeholder="Email">
                                        @error('email')
                                            <strong style="color:red">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <h3 class="input_title">Referl code</h3>
                                    <div class="form_item">
                                        <label></label>
                                        <input id="refer_input" type="text" name="referrel_code"
                                            value="{{ $referrel }}"
                                            placeholder="Enter refer code (optional)"style="pointer-events:none;background-color:lightgrey;">
                                        @error('referrel_code')
                                            <strong style="color:red">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form_item_wrap">
                                    <button type="submit" class="btn btn_secondary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <a href="{{ url('/github/redirect') }}"class="btn btn-secondary">Login with Github</a>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ url('/google/redirect') }}"class="btn btn-success">Login with google</a>
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ url('/facebook/redirect') }}"class="btn btn-primary">Login with Facebook</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- register_section - end
                                                                                                                                                                            ================================================== -->
@endsection
