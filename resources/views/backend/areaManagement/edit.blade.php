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
            <div class="card-header"><b>Edit Area Management</b>
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('banner.index') }}">Area Management</a>
                </span>
            </div>

            <div class="card-body">
                {!! Form::model($areaManagement, ['route' => ['areaManagement.update', $areaManagement->id], 'method'=>'PATCH']) !!}
                @csrf
                <div class="form-group">
                    <strong>Pincode</strong>
                    <input type="Pincode" name="pincode" value="{{$areaManagement->pincode}}" class="form-control" required>
                </div>
                <div class="form-group">
                        <strong>Status:</strong>
                        <br/>
                        <select name="status" class="form-control">
                            @foreach(Helper::getCommonStatus() as $value)
                            <option value="{{$value}}" {{$areaManagement->status == $value ? "selected" : ""}}>{{$value}}</option>
                            @endforeach
                        </select>

                    </div>
                <div class="row">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
