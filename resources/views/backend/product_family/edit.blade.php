@extends('backend.common.layout')
@extends('backend.common.header')
@extends('backend.common.leftside')
@extends('backend.common.rightside')
@extends('backend.common.footer')
@section('content')
<div class="content-wrapper">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header"><b>Edit Product Family</b>
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('product-family.index') }}">Product Families</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::model($family, ['route' => ['product-family.update', $family->id],'method' => 'PATCH','enctype'=>'multipart/form-data']) !!}
                    <div class="form-group">
                        <strong>Name:</strong>
                       <input type="text" class="form-control" value="{{ $family->name }}" name="name" required>
                    </div>
                    <div class="form-group">
                        <strong>Order No:</strong>
                       <input type="number" class="form-control" value="{{ $family->order_no }}" name="order_no" required>
                    </div>
                    <div class="form-group">
                        <strong>Status:</strong>
                        <select name="status" class="form-control">
                            @foreach(Helper::getCommonStatus() as $value)
                                <option value="{{$value}}" {{$value == $family->status ? "selected" : ""}}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
