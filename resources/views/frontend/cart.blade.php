@extends('frontend.master')
@section('content')
<!-- breadcrumb_section - start
            ================================================== -->
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
            ================================================== -->

<!-- cart_section - start
================================================== -->
<section class="cart_section section_space">
    <div class="container">

        <div class="cart_table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $subtotal=0;
                    @endphp
                    @foreach($carts as $cart)
                    <tr>
                        <td>
                            <div class="cart_product">
                                <img src="{{asset('uploads/product/preview')}}/{{$cart->rel_to_product->preview}}" alt="image_not_found">
                                <h3><a href="shop_details.html">{{$cart->rel_to_product->product_name}}</a></h3>
                            </div>
                        </td>
                        <td class="text-center abc"><span class="price_text">TK {{$cart->rel_to_product->after_discount}}</span></td>
                        <td class="text-center abc ">
                            <form action="{{route('cart.update')}}" method="POST">
                                @csrf

                                <div class="quantity_input ">
                                    <button type="button">
                                        <i data-price="{{$cart->rel_to_product->after_discount}}" class="fal fa-minus"></i>
                                    </button>
                                    <input type="text" name="quantity[{{$cart->id}}]" value="{{$cart->quantity}}" />
                                    <button type="button">
                                        <i data-price="{{$cart->rel_to_product->after_discount}}" class="fal fa-plus"></i>
                                    </button>
                                </div>

                        </td>
                        <td class="text-center abc"><span class="price_text">TK {{$cart->rel_to_product->after_discount*$cart->quantity}}</span></td>
                        <td class="text-center abc"><a href="{{route('cart.delete',$cart->id)}}" class="remove_btn"><i class="fal fa-trash-alt"></i></a></td>
                    </tr>
                    @php
                    $subtotal += $cart->rel_to_product->after_discount*$cart->quantity;
                    @endphp
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="cart_btns_wrap">
            <div class="row">
                <div class="col col-lg-6">
                    <ul class="btns_group ul_li_right">
                        <li><button class="btn border_black" type="submit">Update Cart</button></li>
                        </form>
                        @php
                        if($copun_type == 2){
                        $after_discount_final=$subtotal*$discount/100;
                        if($subtotal >= 500 && $subtotal <= 4999){ $discount_final=$after_discount_final; } elseif($subtotal>= 5000 && $subtotal <= 9999){ $discount_final=2000; } elseif($subtotal>= 10000 && $subtotal <= 19999){ $discount_final=3000; } elseif($subtotal>= 20000 && $subtotal <= 39999){ $discount_final=4000; } else{ $discount_final=6000; } } else{ $discount_final=$discount; } @endphp @php session([ 'discount_final'=>$discount_final,
                                        ])
                                        @endphp
                                        <li><a class="btn btn_dark" href="{{route('checkout')}}">Prceed To Checkout</a></li>
                    </ul>
                </div>
                <div class="col col-lg-6">
                    @if($message) <div class="alert alert-danger">{{$message}}</div>
                    @endif
                    <form action="#">
                        <div class="coupon_form form_item mb-0">
                            <input type="text" name="copun_name" placeholder="Coupon Code..." value="{{ @$_GET['copun_name']}}">
                            <button type="submit" class="btn btn_dark">Apply Coupon</button>
                            <div class="info_icon">
                                <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Info Here"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col col-lg-12">
                <div class="cart_total_table">
                    <h3 class="wrap_title">Cart Totals</h3>
                    <ul class="ul_li_block">
                        <li>
                            <span>Cart Subtotal</span>
                            <span>{{ $subtotal}}</span>
                        </li>
                        <li>
                            <span>discount</span>
                            <span>{{$discount_final}}</span>
                        </li>
                        <li>
                            <span>Order Total</span>
                            <span class="total_price">{{$subtotal-$discount_final}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- cart_section - end
 ================================================== -->

@endsection
@section('footer_script')
<script>
    var quantity_input = document.querySelectorAll('.abc');
    var arr = Array.from(quantity_input);

    arr.map(item => {
        item.addEventListener('click', function(e) {
            if (e.target.className == 'fal fa-plus') {

                e.target.parentElement.previousElementSibling.value++

                var quantity = e.target.parentElement.previousElementSibling.value
                var price = e.target.dataset.price
                item.nextElementSibling.innerHTML = price * quantity

            }
            if (e.target.className == 'fal fa-minus') {
                if (e.target.parentElement.nextElementSibling.value > 1) {
                    e.target.parentElement.nextElementSibling.value--

                    var quantity = e.target.parentElement.nextElementSibling.value
                    var price = e.target.dataset.price
                    item.nextElementSibling.innerHTML = price * quantity
                }



            }

        });
    });
</script>
@endsection