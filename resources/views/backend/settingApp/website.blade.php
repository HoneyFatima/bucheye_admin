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
            <div class="card-header"><b>Website Setting</b>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'manage-website-setting.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                    <div class="form-group">
                        <strong>About:</strong>
                        <textarea name="about" class="form-control summernote">{{ @$setting->about }}</textarea>
                    </div>
                    <div class="form-group">
                        <strong>Privacy Policy:</strong>
                        <textarea name="privacy_policy" class="form-control summernote">{{ @$setting->privacy_policy }}</textarea>
                    </div>
                    <div class="form-group">
                        <strong>Term & Conditions:</strong>
                        <textarea name="term_condition" class="form-control summernote">{{ @$setting->term_condition }}</textarea>
                    </div>
                    <div class="form-group">
                        <strong>Logo:</strong>
                        <input type="file" name="logo" class="form-control">
                    </div>

                    <img src="{{ url(@$setting->logo ? @$setting->logo : "")}}" class="img-responsive" alt="">
                    <br>

                    <button type="submit" class="btn btn-primary">Update</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('.summernote').summernote()
    </script>
@endpush
@endsection
