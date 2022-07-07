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
                <div class="card-header"><b>Show Notification</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('notification.create') }}">New Notification</a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $key => $notification)
                                <tr>
                                    <td>{{ $notification->id }}</td>
                                    <td>{{ $notification->name }}</td>
                                    <td>{{ $notification->message }}</td>
                                    <td>{{ $notification->status }}</td>
                                    <td>
                                        @can('notification-edit')
                                            <a class="btn btn-primary"
                                                href="{{ route('notification.edit', $notification->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('notification-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this notification?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['notification.destroy', $notification->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $notifications->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection
