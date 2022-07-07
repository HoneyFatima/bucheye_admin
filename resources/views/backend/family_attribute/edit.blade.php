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
            <div class="card-header"><b>Assign Family Attribute</b>
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('family-attribute.index') }}">Family Attribute</a>
                </span>
            </div>
            <div class="card-body">
                {!! Form::model($families, ['route' => ['family-attribute.update', $families->id],'method' => 'PATCH']) !!}
                    <div class="form-group">
                        <strong>Product Family:</strong>
                       <select name="product_family_id" id="" class="form-control" readonly>
                            <option value="{{ $families->family->id }}">{{ $families->family->name}}</option>

                       </select>
                    </div>
                    <div class="form-group">
                        <strong>Product Attribute:</strong>
                        <select name="product_attribute_id" id="product_attribute_id" class="form-control select2bs4">
                            @foreach ($attribuites as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $families->product_attribute_id ? "selected" :"" }}>{{ $item->name }}/{{ $item->type }}</option>
                            @endforeach
                       </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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
