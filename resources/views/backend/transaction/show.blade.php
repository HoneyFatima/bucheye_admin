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
                <div class="lead">
                    <strong>User Name:</strong>
                    {{ @$transaction->users->name }}
                </div>
                <div class="lead">
                    <strong>Transaction Amount:</strong>
                    {{ @$transaction->transactiondetails->trans_amount }}
                </div>
                <div class="lead">
                    <strong>Transaction Type:</strong>
                    {{ @$transaction->transactiondetails->trans_type }}
                </div>
                <div class="lead">
                    <strong>Transaction Date:</strong>
                    {{ @$transaction->transactiondetails->trans_date }}
                </div>
                {{-- <div class="lead">
                    <strong>Amount:</strong>
                    {{ $user->trans_amount }}
                </div> --}}

            </div>
        </div>
    </div>
</div>
@endsection
