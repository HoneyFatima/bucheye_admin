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
            <div class="card-header"><b>Transaction</b>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Transaction Id</th>
                            <th>Transaction Amount</th>
                            <th>Current Amount</th>
                            <th>Transaction Type </th>
                            <th>Transaction Date</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $transaction)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ @$transaction->users->name }}</td>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ @$transaction->transactiondetails->trans_amount }}</td>
                                <td>{{ @$transaction->transactiondetails->current_amount }}</td>
                                <td>{{ @$transaction->transactiondetails->trans_type }}</td>
                                <td>{{ @$transaction->transactiondetails->trans_date }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('transaction.show',$transaction->id) }}"><i class="far fa-eye"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->render() }}
            </div>
        </div>
    </div>
</div>
@endsection
