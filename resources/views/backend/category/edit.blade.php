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
            <div class="card-header"><b>Edit Category</b>
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('category.index') }}">Categories</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::model($category, ['route' => ['category.update', $category->id],'method' => 'PATCH','enctype'=>'multipart/form-data']) !!}
                    <div class="form-group">
                        <strong>Parent Category:</strong>
                    <select name="parent_id" id="" class="form-control">
                        <option value="#">Select Parent Category</option>
                        @foreach ($categoriers as $item)
                            <option value="{{$item->id}}" {{$category->parent_id == $item->id ? "selected" : ""}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                        <strong>Name:</strong>
                       <input type="text" class="form-control" name="name" value={{$category->name}} required>
                    </div>
                    <div class="form-group">
                        <strong>Image:</strong>
                       <input type="file" name="image" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <strong>Status:</strong>
                        <select name="status" class="form-control">
                            @foreach(Helper::getCommonStatus() as $value)
                                <option value="{{$value}}" {{$value == $category->status ? "selected" : ""}}>{{$value}}</option>
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
