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
            <div class="card-header"><b>Create Banner</b>
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('banner.index') }}">Banner</a>
                </span>
            </div>

            <div class="card-body">
                <form action="{{route('banner.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <strong>Image</strong>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <strong>Link</strong>
                            <input type="text" name="link" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label name="status">Application</label>
                            <select class="form-control" name="application" required>
                                    <option value="user">User App</option>
                                    <option value="vendor">Vendor App</option>
                                    <option value="delivery">Delivery App</option>
                                    <option value="website">Website</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label name="status">Banner Type</label>
                            <select class="form-control" name="banner_type" required>
                                @foreach (Helper::getBannerType() as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label name="status">Status</label>
                            <select class="form-control" name="status" required>
                                @foreach (Helper::getCommonStatus() as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
