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
                <div class="card-header"><b>Edit Product Attribute</b>
                    @can('role-create')
                        <span class="float-right">
                            <a class="btn btn-primary" href="{{ route('product-attribute.index') }}">Product Attribute</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif

                            <form class="forms-sample" method="post" enctype="multipart/form-data"
                            action="{{ route('product-attribute.update', $attribute->id) }}">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="col-form-label">Attribute Name</label>
                                </div>
                                <div class="col-lg-8">
                                    <input class="form-control" name="name" type="text"
                                        placeholder="enter attriobute name here" value="{{$attribute->name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="col-form-label">Attribute Type</label>
                                </div>
                                <div class="col-lg-8">
                                    <select name="type" id="" class="form-control" disabled required>
                                        <option value="{{$attribute->type}}">{{ucfirst(trans($attribute->type))}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label class="col-form-label">Required</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select name="mendetory" id="" class="form-control" required>
                                            <option value="Yes" {{ $attribute->mendetory == "Yes" ? 'selected' : '' }}>Yes</option>
                                            <option value="No" {{ ($attribute->mendetory) == 'No' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="col-form-label">Status</label>
                                </div>
                                <div class="col-lg-8">
                                    <select name="status" id="" class="form-control" required>
                                        <option value="Active" {{ $attribute->status == "Active" ? 'selected' : '' }}>Active</option>
                                        <option value="DeActive" {{ $attribute->status == "DeActive" ? 'selected' : '' }}>DeActive</option>
                                    </select>
                                </div>
                            </div>
                            @php
                                $optionvalidateArray=['select','multiselect','checkbox','radio'];
                            @endphp
                            @if(in_array($attribute->type,$optionvalidateArray))
                                <nav class="page-breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Options</li>

                                    </ol>
                                </nav>
                                @if(count($attribute->attributeDetails) > 0)
                                    @foreach ($attribute->attributeDetails as $item)
                                        <div class="row mt-4">
                                            <div class="col-lg-3">
                                                <label class="col-form-label">Attribute Option Name</label>
                                                <input class="form-control"  type="text"
                                                    placeholder="enter attribute option name here" value="{{$item['label']}}" readonly>
                                            </div>


                                            <div class="col-lg-3">
                                                <label class="col-form-label">Attribute Option Value</label>
                                                <input class="form-control" type="text"
                                                    placeholder="enter attribute option value here"  value="{{$item['value']}}"readonly>
                                            </div>

                                            <div class="col-lg-3">
                                                <label class="col-form-label">Attribute Option Order</label>
                                                <input class="form-control" type="number"
                                                    placeholder="enter attribute option order here"  value="{{$item['order_no']}}"readonly>
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="col-form-label">Action</label><br>
                                                <a href="{{route('attributeValue.delete',$item->id)}}">
                                                    <button type="button"  class="btn btn-danger">Delete</button>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                @endif
                                <button type="button" name="add" id="add" class="btn btn-success btn-block mt-4">Add More</button>

                                <div id="dynamic_field" ></div>
                            @endif

                            <div class="form-group row">
                                <button type="submit" class="btn btn-primary btn-block mt-2">Update</button>
                            </div>

                        </form>
                </div>
            </div>
        </div>
    </div>
   @push('scripts')
   <script>
    var i=1;
    $('#add').click(function(){
           i++;
           $('#dynamic_field').append(
                '<div id="row'+i+'" class="dynamic-added row mt-4">'+
                '<div class="col-lg-3">'+
                    '<label class="col-form-label">Attribute Option Name</label>'+
                    '<input class="form-control" name="label[]" type="text"'+
                        'placeholder="enter attribute option name here"  required>'+
                '</div>'+

                '<div class="col-lg-3">'+
                    '<label class="col-form-label">Attribute Option Value</label>'+
                    '<input class="form-control" name="value[]" type="text"'+
                        'placeholder="enter attribute option value here"  required>'+
                '</div>'+
                '<div class="col-lg-3">'+
                    '<label class="col-form-label">Attribute Option Order</label>'+
                    '<input class="form-control" name="order_no[]" type="number"'+
                        'placeholder="enter attribute option order here"  required>'+
                '</div>'+
                '<div class="col-lg-3">'+
                    '<label class="col-form-label">Action</label><br>'+
                    '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">Delete</button>'+
                '</div></div>'
            );
      });


      $(document).on('click', '.btn_remove', function(){
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();
      });
</script>
   @endpush
@endsection
