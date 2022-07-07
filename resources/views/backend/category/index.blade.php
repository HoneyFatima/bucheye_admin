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
                <div class="card-header"><b>Categories</b>
                    @can('role-create')
                        <span class="float-right">
                            <a class="btn btn-primary" href="{{ route('category.create') }}">New Category</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Parent Category</th>
                                <th>status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><img src="{{ url($item->image ? $item->image : '') }}" alt="{{ $item->name }}"
                                            style="width:150px;"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->childCategory ? $item->childCategory->name : '-' }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        @can('category-edit')
                                            <a class="btn btn-primary" href="{{ route('category.edit', $item->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('category-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this category?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['category.destroy', $item->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection
