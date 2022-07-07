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
                <div class="card-header"><b>Area Management</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('areaManagement.create') }}">New Area Management</a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>pincode</th>
                                <th>status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($areaManagement as $key => $area)
                                <tr>
                                    <td>{{ $area->id }}</td>
                                    <td>{{ $area->pincode }}</td>
                                    <td>{{ $area->status }}</td>
                                    <td>
                                        @can('areaManagement-edit')
                                            <a class="btn btn-primary" href="{{ route('areaManagement.edit', $area->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('areaManagement-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this area?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['areaManagement.destroy', $area->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $areaManagement->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
