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
            <div class="card-header"><b>Banner</b>
                @can('role-create')
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('banner.index') }}">Back</a>
                    </span>
                @endcan
            </div>
            <div class="card-body">
                <div class="lead">
                    <strong>Image:</strong>
                    {{ $banner->Image }}
                </div>
                <div class="lead">
                    <strong>Status:</strong>
                    {{ $banner->status }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
