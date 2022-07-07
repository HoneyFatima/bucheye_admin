@extends('backend.common.layout')
@extends('backend.common.header')
@extends('backend.common.leftside')
@extends('backend.common.rightside')
@extends('backend.common.footer')
@section('content')
    <div class="content-wrapper">
        <div class="justify-content-center">
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div>
            @endif
            <div class="card">
                <div class="card-header"><b>Orders</b>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Order Number</th>
                                <th>Offer</th>
                                <th>Coupon</th>
                                <th>Address</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ @$order->user->name }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ @$order->offer->name }}</td>
                                    <td>{{ @$order->coupon->name }}</td>
                                    <td>{{ @$order->address->name }}</td>
                                    <td>{{ $order->order_status }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success"
                                            onclick="orderDetails({{ $order->id }},'order_detaila')"
                                            style='margin-right:16px'>
                                            View Details
                                        </button>
                                        <button type="button" class="btn btn-success"
                                            onclick="orderDetails({{ $order->id }},'invoice')"
                                            style='margin-right:16px'>
                                            Invoice
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->render() }}
                    <div class="modal fade" id="order_details_modal">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modal_title"></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="body_details">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function orderDetails(id, type) {
                AmagiLoader.show();
                setTimeout(() => {
                    AmagiLoader.hide();
                }, 500);
                if (type == "invoice") {
                    $('#modal_title').html('Invoice');
                } else {
                    $('#modal_title').html('Order Details');
                }
                $.ajax({
                    type: 'get',
                    url: '{{ route('get.order.details') }}',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        $('#body_details').html(res);
                        $('#order_details_modal').modal('show');
                    }
                });
            }
        </script>
    @endpush
@endsection
