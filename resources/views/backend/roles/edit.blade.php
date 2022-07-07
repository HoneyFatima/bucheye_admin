@extends('backend.common.layout')
@extends('backend.common.header')
@extends('backend.common.leftside')
@extends('backend.common.rightside')
@extends('backend.common.footer')
@section('content')
<div class="content-wrapper">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header"><b>Edit role</b>
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}">Roles</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::model($role, ['route' => ['roles.update', $role->id],'method' => 'PATCH']) !!}
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <strong>Permission:</strong>
                        <br/>
                       <select name="permission[]" id="" class="form-control duallistbox" multiple="multiple"
                       data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;"
                       required multiple>
                            @foreach($permission as $value)
                                <option value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
                       </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('.duallistbox').bootstrapDualListbox();
    </script>
@endpush
@endsection
