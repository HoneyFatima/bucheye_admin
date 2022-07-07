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
                <div class="card-header"><b>Coupons</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('coupons.create') }}">New Coupons</a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Minimum Price</th>
                                <th>Discount Type</th>
                                <th>Discount Value</th>
                                <th>Maximum Discount</th>
                                <th>Expiry Date</th>
                                <th>Description</th>
                                <th>Term Condition</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $key => $coupon)
                                <tr>
                                    <td>{{ $coupon->id }}</td>
                                    <td>{{ $coupon->name }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->min_price }}</td>
                                    <td>{{ $coupon->discount_type }}</td>
                                    <td>{{ $coupon->discount_value }}</td>
                                    <td>{{ $coupon->max_discount }}</td>
                                    <td>{{ $coupon->expiry_date }}</td>
                                    <td>{{ $coupon->description }}</td>
                                    <td>{{ $coupon->term_condition }}</td>
                                    <td>{{ $coupon->status }}</td>
                                    <td>
                                        @can('coupons-edit')
                                            <a class="btn btn-primary" href="{{ route('coupons.edit', $coupon->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('coupons-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this coupon?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $coupons->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection
