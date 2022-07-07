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
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div>
            @endif
            <div class="card">
                <div class="card-header"><b>Create Product</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('product.index') }}">Products</a>
                    </span>
                </div>
                <div class="card-body">
                    {!! Form::model($product, ['route' => ['product.update', $product->id], 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                    </div>
                    <div class="form-group">
                        <strong>Product Family:</strong>
                        <br />
                        <select name="family_id" class="form-control" disabled>
                            <option value="">Select Product Family</option>
                            @foreach ($families as $value)
                                <option value="{{ $value->id }}"
                                    {{ $value->id == $product->family_id ? 'selected' : '' }}>{{ $value->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    @if (isset($product->product_details))
                        @foreach ($product->product_details as $item)
                            @php
                                $type = @$item->attribute->type;
                                $required = '';
                                if ($item->attribute->required == 'Yes') {
                                    $required = 'required';
                                }
                            @endphp
                            @if ($type == 'text' || $type == 'price' || $type == 'date' || $type == 'time' || $type == 'file' || $type == 'datetime-local')
                                <div class="form-group">
                                    <label class="col-form-label">{{ $item->attribute->name }}</label>

                                    <input class="form-control" name="{{ $item->attribute->id }}"
                                        type="{{ $type }}" placeholder="enter {{ $item->attribute->name }} here"
                                        value="{{ $item->product_attribute_value }}" {{ $required }}>

                                </div>
                            @endif
                            @if ($type == 'textarea')
                                <div class="form-group ">
                                    <label class="col-form-label">{{ $item->attribute->name }}</label>
                                    <textarea class="form-control" name="{{ $item->attribute->id }}"
                                        placeholder="enter {{ $item->attribute->name }} here"
                                        {{ $required }}>{{ $item->product_attribute_value }}</textarea>

                                </div>
                            @endif
                            @if ($type == 'radio')
                                <div class="form-group">
                                    <label class="col-form-label">{{ $item->attribute->name }}</label>
                                    @if (count($item->attribute->attributeDetails) > 0)
                                        @foreach ($item->attribute->attributeDetails as $details)
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">{{ $details->label }}</label>
                                                <input class="form-check-input ml-4" name="{{ $item->attribute->id }}"
                                                    type="radio" value="{{ $details->value }}" {{ $required }}
                                                    {{ $details->value == $item->product_attribute_value ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                            @if ($type == 'checkbox')
                                <div class="form-group ">
                                    <label class="col-form-label">{{ $item->attribute->name }}</label>
                                    @if (count($item->attribute->attributeDetails) > 0)
                                        @foreach ($item->attribute->attributeDetails as $details)
                                            @php
                                                $value_array = explode(',', $item['value']);
                                            @endphp
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">{{ $details->label }}</label>
                                                <input class="form-check-input ml-4" name="{{ $itemattribute->id }}[]"
                                                    type="checkbox" value="{{ $details->value }}"
                                                    {{ in_array($details->value, $value_array) ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                            @if ($type == 'select')
                                <div class="form-group ">
                                    <label class="col-form-label">{{ $item->attribute->name }}</label>
                                    @if (count($item->attribute->attributeDetails) > 0)
                                        <select name="" id="" class="form-control" {{ $required }}>
                                            <option value="">Select {{ $item->attribute->name }}
                                            </option>
                                            @foreach ($item->attribute->attributeDetails as $details)
                                                <option value="{{ $details->value }}"
                                                    {{ $item->product_attribute_value == $details->value ? 'selected' : '' }}>
                                                    {{ $details->label }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <div id="attribute_list"></div>
                    
                    <div class="form-group">
                        <strong>Category:</strong>
                        <input type="hidden" name="category_id" id="category_id" value={{ $product->category_id }} required>
                        <div id="jstree">
                            
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <strong>Size:</strong>
                        <input class="form-control" name="size" type="text"
                            value="{{ $product->size }}" required>
                    </div>
                    
                    <div class="form-group">
                        <strong>Color:</strong>
                        <input class="form-control" name="color" type="text"
                            value="{{ $product->color }}" required>
                    </div>
                    <div class="form-group">
                        <strong>Brand:</strong>
                        <input type="text" name="brand" id="brand" class="form-control" value="{{ $product->brand }}">
                        
                        
                    </div>
                    
                    <div class="form-group">
                        <strong>Product Availability Pincode:</strong>
                        <br />
                        <select name="pincode_availability[]" class="form-control duallistbox" multiple="multiple"
                            data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;"
                            required>
                            @foreach ($pincodes as $value)
                                <option value="{{ $value->id }}" @if (in_array($value->id, explode(',', $product->pincode_availability))) selected @endif>
                                    {{ $value->pincode }}</option>
                            @endforeach
                        </select>

                    </div>
                    {{-- <div id="food_family_field">
                        <div class="form-group form-check-inline">
                            <strong>Product Type:</strong>
                            <label class="form-check-label" style="margin-left:100px;">Veg</label>
                            <input class="form-check-input ml-4" name="product_type" type="radio" value="Veg"
                                {{ $product->product_type == 'Veg' ? 'checked' : '' }}>

                            <label class="form-check-label" style="margin-left:100px;">Non-Veg</label>
                            <input class="form-check-input ml-4" name="product_type" type="radio" value="NoneVeg"
                                {{ $product->product_type == 'NoneVeg' ? 'checked' : '' }}>

                            <label class="form-check-label" style="margin-left:100px;">None</label>
                            <input class="form-check-input ml-4" name="product_type" type="radio" value="None"
                                {{ $product->product_type == 'None' ? 'checked' : '' }}>

                        </div>
                    </div> --}}
                    <div class="form-group">
                        <strong>Product Quantity:</strong>
                        <input type="number" class="form-control" name="product_quantity"
                            value="{{ $product->product_quantity }}" required>
                    </div>
                    <div class="form-group">
                        <strong>Unit Type:</strong>
                        <select name="unit_type" id="" class="form-control">
                            @foreach ($unit_types as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id == $product->unit_type ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>Unit Value:</strong>
                        <input type="text" class="form-control" name="unit" value="{{ $product->unit }}" required>
                    </div>
                    <div class="form-group">
                        <strong>MRP:</strong>
                        <input type="number" class="form-control" name="mrp" id="mrp" value="{{ $product->mrp }}" required>
                    </div>
                    <div class="form-group">
                        <strong>Is Discount:</strong>
                        <select name="discount_type" id="discount" class="form-control" onchange="sellPriceCalculate(this.value)">
                            <option value="">Select Discount</option>
                            <option value="fixed" {{ $product->discount_type  == "fixed" ? "selected" : ""}}>Fixed</option>
                            <option value="percentage" {{ $product->discount_type  == "percentage" ? "selected" : ""}}>Percentage</option>
                        </select>
                    </div>
                    <div class="form-group" id="discount_value_div">
                        <strong>Discount Value:</strong>
                        <input type="number" class="form-control" value="{{ $product->discount_value }}" id="discount_value" name="discount_value">
                    </div>
                    <div class="form-group">
                        <strong>Final Amount:</strong>
                        <input type="number" id="final_amount" value="{{ $product->final_amount }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <strong>Product Quantity Restrictions:</strong><br>
                        <input type="checkbox" id="restrictions" name="restrictions"
                            {{ $product->restrictions == true ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled"
                            data-off="Disabled" data-onstyle="outline-primary" data-offstyle="outline-secondary">
                    </div>
                    
                    <div class="form-group" id="restrictions_quantity_div">
                        <strong>Product Quantity:</strong>
                        <input type="number" id="restrictions_quantity" class="form-control"
                            value="{{ $product->restrictions_quantity }}" name="restrictions_quantity">
                    </div>
                    
                    <div class="form-group">
                        <strong>Product Thumnails:</strong>
                        <input type="file" class="form-control" name="thumnails">
                    </div>
                    <div class="form-group">
                        <strong>Sort Descreption:</strong>
                        <textarea name="short_description" id=""
                            class="form-control"> {{ $product->short_description }}</textarea>
                    </div>
                    <div class="form-group">
                        <strong>Long Descreption:</strong>
                        <textarea name="long_description" id=""
                            class="form-control"> {{ $product->long_description }}</textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Product Image</label>
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control" name="product_image[]" type="file">
                        </div>
                        <div class="col-lg-2">
                            <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                        </div>
                    </div>
                    <div id="images_field"></div>
                    <hr>
                    <div class="form-group row mt-2">
                        <div class="col-lg-3">
                            <label class="col-form-label">Product Video</label>
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control" name="product_video[]" type="file">
                        </div>
                        <div class="col-lg-2">
                            <button type="button" name="add" id="add_video" class="btn btn-success">Add More</button>
                        </div>
                    </div>
                    <div id="videos_field"></div>
                    <div class="form-group">
                        <strong>Status:</strong>
                        <br />
                        <select name="status" class="form-control">
                            @foreach (Helper::getCommonStatus() as $value)
                                <option value="{{ $value }}" {{ $value == $product->status ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>

                    </div>
                    <button type="submit" class="btn btn-primary">update</button>
                    {!! Form::close() !!}
                    @if (!empty($product->images))
                        <nav class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Product Images</li>
                            </ol>
                        </nav>
                        <div style="height: 400px; overflow-y: scroll;overflow-x: hidden;">
                            <hr>
                            @foreach ($product->images as $item)
                                <div class="row mt-4">

                                    <div class="col-lg-4">
                                        <label class="col-form-label">Product Image</label><br>
                                        <img src="{{ url($item->image_path) }}" alt="" class="img-thumbnail"
                                            style="width: 150px;">
                                    </div>
                                    <div class="col-lg-6">

                                        <form action="{{ route('product.image.update', $item->id) }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label class="col-form-label"
                                                        style="margin-left: 30px;">Status</label><br>
                                                    <select name="status" id="" class="form-control">
                                                        <option value="Active"
                                                            {{ $item->status == 'Active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="Pending"
                                                            {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="col-lg-8 offset-lg-3">
                                                        <br>
                                                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="col-form-label">Action</label><br>
                                        <a href="{{ route('productImage.delete', $item->id) }}">
                                            <button type="button" class="btn btn-danger">Delete</button>
                                        </a>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    @endif
                    @if (!empty($product->videos))
                        <nav class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Product Videos</li>
                            </ol>
                        </nav>
                        <div style="height: 400px; overflow-y: scroll;overflow-x: hidden;">
                            <hr>
                            @foreach ($product->videos as $item)
                                <div class="row mt-4">

                                    <div class="col-lg-4">
                                        <label class="col-form-label">Product Video</label><br>
                                        <video width="320" height="240" controls>
                                            <source src="{{ url($item->video_path) }}" type="video/mp4">
                                        </video>
                                    </div>
                                    <div class="col-lg-6">

                                        <form action="{{ route('product.video.update', $item->id) }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label class="col-form-label"
                                                        style="margin-left: 30px;">Status</label><br>
                                                    <select name="status" id="" class="form-control">
                                                        <option value="Active"
                                                            {{ $item->status == 'Active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="Pending"
                                                            {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="col-lg-8 offset-lg-3">
                                                        <br>
                                                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="col-form-label">Action</label><br>
                                        <a href="{{ route('product.video.delete', $item->id) }}">
                                            <button type="button" class="btn btn-danger">Delete</button>
                                        </a>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var restrictions=@json($product->restrictions);
            if(restrictions){
                $('#restrictions_quantity_div').show();
            }else{
                $('#restrictions_quantity_div').hide();
            }
            $(function() {
                $('#restrictions').change(function() {
                    if ($(this).prop('checked') == true) {
                        $('#restrictions_quantity').val(0);
                        $('#restrictions_quantity_div').show();
                    } else {
                        $('#restrictions_quantity_div').hide();
                    }
                })
            });
            $('.duallistbox').bootstrapDualListbox();
            var i = 1;
            $('#add').click(function() {
                i++;
                $('#images_field').append(
                    '<div id="row' + i + '" class="dynamic-added row mt-4">' +

                    '<div class="col-lg-3">' +
                    '<label class="col-form-label">Product Image ' + i + '</label>' +
                    '</div>' +
                    ' <div class="col-lg-6">' +
                    '<input class="form-control" name="product_image[]" type="file">' +
                    '</div>' +


                    '<div class="col-lg-3">' +

                    '<button type="button" name="remove" id="' + i +
                    '" class="btn btn-danger btn_remove">Delete</button>' +
                    '</div></div>'
                );
            });

            // Product Video Field
            var v = 1;
            $('#add_video').click(function() {
                i++;
                $('#videos_field').append(
                    '<div id="rowvideo' + v + '" class="dynamic-added row mt-4">' +

                    '<div class="col-lg-3">' +
                    '<label class="col-form-label">Product Video ' + v + '</label>' +
                    '</div>' +
                    ' <div class="col-lg-6">' +
                    '<input class="form-control" name="product_video[]" type="file">' +
                    '</div>' +


                    '<div class="col-lg-3">' +

                    '<button type="button" name="remove" id="video' + v +
                    '" class="btn btn-danger btn_remove">Delete</button>' +
                    '</div></div>'
                );
            });


            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#rowvideo' + button_id + '').remove();
            });


            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
            $('#food_family_field').hide();
            function getFamilyAttribute(family_id) {
                $('.loader').show();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('product.attribute') }}',
                    data: {
                        family_id: family_id
                    },
                    success: function(data) {
                        $('.loader').hide();
                        var column = '';
                        $.each(data.data.attributes, function(key, val) {
                            var type = val.type;
                            var required = '';
                            if (val.mendetory == "Yes") {
                                required = 'required';
                            }

                            if (type == "text" || type == "price" || type == "date" || type == "time" ||
                                type == "file" || type == "datetime-local") {
                                column += '<div class="form-group">' +
                                    '<strong>' + val.name +
                                    ':</strong>' +
                                    '<input class="form-control" name="' + val.id +
                                    '" type="' + type + '" placeholder="enter ' + val
                                    .name + ' here" value="" ' + required + '>' +
                                    '</div>';
                            }
                            if (type == "textarea") {
                                column += '<div class="form-group">' +
                                    '<strong">' + val.name +
                                    ':</strong>' +
                                    '<textarea class="form-control" name="' + val.id +
                                    '" placeholder="enter ' + val.name + ' here" ' +
                                    required + '></textarea>' +
                                    '</div>';
                            }
                            if (type == "radio") {
                                if (val.attribute_details) {
                                    column += '<div class="form-group form-check-inline">' +
                                        '<strong>' + val.name + ':</strong>';
                                    $.each(val.attribute_details, function(checkBoxKey,
                                        checkBoxVal) {
                                        column +=
                                            '<label class="form-check-label" style="margin-left:100px;">' +
                                            checkBoxVal.label +
                                            '</label>' +
                                            '<input class="form-check-input ml-4" name="' + val
                                            .id + '" type="radio" value="' +
                                            checkBoxVal.value + '" ' + required + '>';
                                    });
                                    column += '</div>';
                                }

                            }
                            if (type == "checkbox") {
                                if (val.attribute_details) {
                                    column += '<div class="form-group">' +
                                        '<label class="col-form-label">' + val.name +
                                        '</label>' +
                                        '</div>';
                                    $.each(val.attribute_details, function(checkBoxKey,
                                        checkBoxVal) {
                                        column += '<div class="form-check form-check-inline">' +
                                            '<label class="form-check-label">' + checkBoxVal.label +
                                            '</label>' +
                                            '<input class="form-check-input ml-4" name="' + val
                                            .id + '[]" type="' + type +
                                            '" value="' + checkBoxVal.value + '">';
                                    });
                                    column += '</div>';
                                }

                            }

                            if (type == "select") {
                                column += '<div class="form-group">' +
                                    '<strong>' + val.name +
                                    '</strong>' +
                                    '<select name="' + val.id +
                                    '" id="" class="form-control" ' + required + '>';
                                column += '<option value="" >Select ' + val.name +
                                    '</option>';
                                if (val.attribute_details) {
                                    $.each(val.attribute_details, function(optionKey, optionVal) {
                                        column += '<option value="' + optionVal.value + '" >' +
                                            optionVal.label + '</option>';
                                    });
                                }
                                column += '</select>' +
                                    '</div>';
                            }


                        });

                        $('#attribute_list').html(column);
                    }
                });
            }
            

            // sellingPriceCalculate
            if(@json($product->discount_type)){
                $('#discount_value_div').show();
            }else{
                $('#discount_value_div').hide();
            }
            
            function sellPriceCalculate(discount_type){
                
                if(discount_type =="fixed"){
                    $('#discount_value_div').show();
                }else if(discount_type =="percentage"){
                    $('#discount_value_div').show();
                }else{
                    $('#discount_value_div').hide();
                }
                var mrp=$('#mrp').val();
                $('#final_amount').val(mrp);
                // $('#discount_value').val(0);
            }
            
            $('#discount_value').keyup(function(){
                var discount_value=$('#discount_value').val();
                var mrp=$('#mrp').val();
                var discount_type=$('#discount').val();
                if(discount_type =="fixed"){
                    $('#final_amount').val(parseInt(mrp)- parseInt(discount_value));
                }else if(discount_type =="percentage"){
                    
                    var amount=(mrp-(mrp * discount_value)/100);
                    $('#final_amount').val(amount);
                    
                    
                }else{
                    $('#final_amount').val(mrp);
                }
                
            });
            $('#mrp').keyup(function(){
                var discount_value=$('#discount_value').val();
                var mrp=$('#mrp').val();
                var discount_type=$('#discount').val();
                if(discount_type =="fixed"){
                    $('#final_amount').val(parseInt(mrp)- parseInt(discount_value));
                }else if(discount_type =="percentage"){
                    
                    var amount=(mrp-(mrp * discount_value)/100);
                    $('#final_amount').val(amount);
                    
                    
                }else{
                    $('#final_amount').val(mrp);
                }
                
            });
        </script>
        <script>
            $(function () {
                // 6 create an instance when the DOM is ready
                var category_id=@json($product->category_id);
                $('#category_id').val(category_id);
                $('#jstree').jstree({
                    'core' : {
                    'data' : {
                        url:'{{ route("subcategory.get") }}?category_id='+category_id,
                    }
                    }
                }).on('changed.jstree', function (e, data) {
                    if(data.node){
                        $('#category_id').val(data.node.id);
                    }
                   
                   
                });
                
            });
          </script>
    @endpush
@endsection
