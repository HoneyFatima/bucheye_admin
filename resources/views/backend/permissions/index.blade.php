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
                <div class="card-header"><b>Permissions</b>
                    @can('role-create')
                        <span class="float-right">
                            <a class="btn btn-primary" href="{{ route('permissions.create') }}">New Permission</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $permission)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        @can('role-edit')
                                            <a class="btn btn-primary"
                                                href="{{ route('permissions.edit', $permission->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('role-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this permission?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
