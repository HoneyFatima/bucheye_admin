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
                <div class="card-header"><b>Family Attribute</b>
                    @can('role-create')
                        <span class="float-right">
                            <a class="btn btn-primary" href="{{ route('family-attribute.create') }}">Assign/Update Family
                                Attribute</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Family Name</th>
                                <th>Attribute Name</th>
                                <th>Attribute Type</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->family->name }}</td>
                                    <td>{{ @$item->attribute->name ? @$item->attribute->name : '-' }}</td>
                                    <td>{{ @$item->attribute->type ? @$item->attribute->type : '-' }}</td>
                                    <td>
                                        @can('family-attribute-edit')
                                            <a class="btn btn-primary"
                                                href="{{ route('family-attribute.edit', $item->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('family-attribute-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this family attribute?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['family-attribute.destroy', $item->id], 'style' => 'display:inline']) !!}
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
