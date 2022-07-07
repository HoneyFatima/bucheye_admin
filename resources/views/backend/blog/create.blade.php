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
                <div class="card-header"><b>Create Blogs</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('blog.index') }}">Blogs</a>
                    </span>
                </div>

                <div class="card-body">
                    <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <strong>Title</strong>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <strong>Image</strong>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Short Description
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <textarea id="short_description" name="short_description">

                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Long Description
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <textarea id="long_description" name="long_description">

                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label name="status">Status</label>
                                <select class="form-control" name="status" required>
                                    @foreach (Helper::getCommonStatus() as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
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
        @push('scripts')
            <script>
                $('#short_description').summernote()
                $('#long_description').summernote()
            </script>
        @endpush
    @endsection
