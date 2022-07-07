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
                <div class="card-header"><b>Product Attribute</b>
                    @can('role-create')
                        <span class="float-right">
                            <a class="btn btn-primary" href="{{ route('product-attribute.index') }}">Product Attribute</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif

                            <form class="forms-sample" method="post" enctype="multipart/form-data"
                                action="{{ route('product-attribute.store', '') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label class="col-form-label">Attribute Name</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-control" name="name" type="text"
                                            placeholder="enter attribute name here" value="" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label class="col-form-label">Attribute Type</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select name="type" id="" class="form-control" required>
                                            <option value="text">Text</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="number">Number</option>
                                            <option value="radio">Radio</option>
                                            <option value="select">Select</option>
                                            {{-- <option value="multiselect">Multiselect</option> --}}
                                            <option value="datetime-local">Datetime</option>
                                            <option value="date">Date</option>
                                            <option value="time">Time</option>
                                            <option value="file">File</option>
                                            <option value="checkbox">Checkbox</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label class="col-form-label">Required</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select name="mendetory" id="" class="form-control" required>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select name="status" id="" class="form-control" required>
                                            <option value="Active">Active</option>
                                            <option value="DeActive">DeActive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-8 offset-lg-3">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button class="btn btn-light" type="reset">Reset</button>
                                    </div>
                                </div>

                            </form>
                </div>
            </div>
        </div>
    </div>
@endsection
