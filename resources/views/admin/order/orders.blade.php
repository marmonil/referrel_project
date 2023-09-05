@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Order List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Order ID</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Charge</th>
                            <th>Total</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($orders as $key => $order)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->sub_total }}</td>
                                <td>{{ $order->discount }}</td>
                                <td>{{ $order->delivery }}</td>
                                <td>{{ $order->total }}</td>
                                <td>@php
                                    if ($order->status == 1) {
                                        echo '<span class="badge badge-info">Pleaced</span> ';
                                    } elseif ($order->status == 2) {
                                        echo '<span class="badge badge-secondary">Procecing</span>';
                                    } elseif ($order->status == 3) {
                                        echo '<span class="badge badge-primary">Ready to deliver</span>';
                                    } elseif ($order->status == 4) {
                                        echo '<span class="badge badge-warning">Cancel</span>';
                                    } elseif ($order->status == 5) {
                                        echo '<span class="badge badge-danger">Deliverd</span>';
                                    } else {
                                        echo '<span class="badge badge-info">unkonown</span>';
                                    }

                                @endphp
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <form action="{{ route('order.status') }}"method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-success light sharp"
                                                data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <circle fill="#000000" cx="5" cy="12"
                                                            r="2" />
                                                        <circle fill="#000000" cx="12" cy="12"
                                                            r="2" />
                                                        <circle fill="#000000" cx="19" cy="12"
                                                            r="2" />
                                                    </g>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">

                                                <button value="{{ $order->id . ',' . '1' }}"
                                                    class="dropdown-item status"name="status">Placed</button>
                                                <button value="{{ $order->id . ',' . '2' }}"
                                                    class="dropdown-item status"name="status">Procecing</button>
                                                <button value="{{ $order->id . ',' . '3' }}"
                                                    class="dropdown-item status"name="status">Ready
                                                    to
                                                    deliver</button>
                                                <button value="{{ $order->id . ',' . '4' }}"
                                                    class="dropdown-item status"name="status">Cancel</button>
                                                <button value="{{ $order->id . ',' . '5' }}"
                                                    class="dropdown-item status"name="status">Deliverd</button>
                                            </div>
                                    </div>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                        <input type="number"name="status"id="status">
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
