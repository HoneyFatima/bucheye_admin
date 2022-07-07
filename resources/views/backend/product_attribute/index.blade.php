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
                            <a class="btn btn-primary" href="{{ route('product-attribute.create') }}">New Product Attribute</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Attribute Type</th>
                                <th>Is Mendetory</th>
                                <th>status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->mendetory }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        @can('product-attribute-edit')
                                            <a class="btn btn-primary"
                                                href="{{ route('product-attribute.edit', $item->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('product-attribute-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this product attribute?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['product-attribute.destroy', $item->id], 'style' => 'display:inline']) !!}
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
