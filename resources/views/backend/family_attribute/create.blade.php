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
                {!! Form::open(array('route' => 'family-attribute.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                    <div class="form-group">
                        <strong>Product Family:</strong>
                       <select name="product_family_id" id="" class="form-control" onclick="getProductAttribute(this.value)">
                            <option value="">Select Product Family</option>
                           @foreach ($families as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class="form-group">
                        <strong>Product Attribute:</strong>
                        <select name="product_attribute_id[]" id="product_attribute_id" class="selectpicker" multiple="multiple" data-width="100%">

                       </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <script>
        
        function getProductAttribute(family_id){
            if(family_id){
                $.ajax({
                    type:'GET',
                    url:'{{ route("product.attribute") }}',
                    data:{family_id:family_id},
                     dataType:'json',
                    success:function(data) {
                        $('#product_attribute_id').html('');
                           
                       $.each(data.data.attributes,function(key,val){
                        if(data.data.family_attribute.includes(String(val.id))){
                            $('#product_attribute_id').append('<option value="'+val.id+'" selected>'+val.name+'</option>');
                        }else{
                            $('#product_attribute_id').append('<option value="'+val.id+'">'+val.name+'</option>');
                        }
                        
                       });
                       $('#product_attribute_id').selectpicker('refresh');
                    //    $('.duallistbox').bootstrapDualListbox();
                    }
                });
            }

        }
        //$('#product_attribute_id').selectpicker();
    </script>
@endpush
@endsection
