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
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('banner.create') }}">New Banner</a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>image</th>
                                <th>Application</th>
                                <th>Banner Type</th>
                                <th>link</th>
                                <th>status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $key => $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        <a href="{{ url($banner->image ? $banner->image : '#') }}" target="_blank">
                                            <img src="{{ url($banner->image ? $banner->image : '') }}" alt="alt-text"
                                                style="width:100px;">
                                        </a>
                                    </td>
                                    <td>{{ $banner->application }}</td>
                                    <td>{{ $banner->banner_type }}</td>
                                    <td>{{ $banner->link }}</td>
                                    <td>{{ $banner->status }}</td>
                                    <td>
                                        @can('banner-edit')
                                            <a class="btn btn-primary" href="{{ route('banner.edit', $banner->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('banner-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this banner?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['banner.destroy', $banner->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $banners->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
