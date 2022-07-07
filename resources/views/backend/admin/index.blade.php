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
                <div class="card-header"><b>Admins</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('admin.create') }}">New Admin</a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $val)
                                                <label class="badge badge-dark">{{ $val }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @can('admin-edit')
                                            <a class="btn btn-primary" href="{{ route('admin.edit', $user->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('admin-delete')
                                            @if ($user->id != 1)
                                                <a href="#"
                                                    onclick="javascript:return confirm('Are you sure you want to delete this admin?')">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['admin.destroy', $user->id], 'style' => 'display:inline']) !!}
                                                    {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                    {!! Form::close() !!}
                                                </a>
                                            @endif
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
