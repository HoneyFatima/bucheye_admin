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
                <div class="card-header"><b>Edit Banner</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('banner.index') }}">Banner</a>
                    </span>
                </div>

                <div class="card-body">
                    {!! Form::model($banner, ['route' => ['banner.update', $banner->id], 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
                    @csrf
                    <div class="form-group">
                        <strong>Image</strong>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <strong>Link</strong>
                        <input type="text" name="link" class="form-control" value="{{ $banner->link }}" required>
                    </div>
                    <div class="form-group">
                        <label name="status">Application</label>
                        <select class="form-control" name="application" required>
                                <option value="user" {{ $banner->application == "user" ? 'selected' : '' }}>User App</option>
                                <option value="vendor" {{ $banner->application == "vendor" ? 'selected' : '' }}>Vendor App</option>
                                <option value="delivery" {{ $banner->application == "delivery" ? 'selected' : '' }}>Delivery App</option>
                                <option value="website" {{ $banner->application == "website" ? 'selected' : '' }}>Website</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label name="status">Banner Type</label>
                        <select class="form-control" name="banner_type" required>
                            @foreach (Helper::getBannerType() as $item)
                                <option value="{{$item}}" {{ $banner->banner_type == $item ? 'selected' : '' }}>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label name="status">Status</label>
                        <select class="form-control" name="status" required>
                            @foreach (Helper::getCommonStatus() as $value)
                                <option value="{{ $value }}" {{ $banner->status == $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
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
