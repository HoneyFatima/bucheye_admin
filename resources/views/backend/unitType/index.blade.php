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
                <div class="card-header"><b>Unit Type</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('unitType.create') }}">New Unit Type</a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Short Name</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unitType as $key => $unit)
                                <tr>
                                    <td>{{ $unit->id }}</td>
                                    <td>{{ $unit->name }}</td>
                                    <td>{{ $unit->short_name }}</td>
                                    <td>{{ $unit->status }}</td>
                                    <td>
                                        @can('manage-unit-type-edit')
                                            <a class="btn btn-primary" href="{{ route('unitType.edit', $unit->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('manage-unit-type-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this unit type?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['unitType.destroy', $unit->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                                </a>
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $unitType->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
