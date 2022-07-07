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
                <div class="card-header"><b>Create Product</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('product.index') }}">Products</a>
                    </span>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'product.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <strong>Product Family:</strong>
                        <br />
                        <select name="family_id" class="form-control" onchange="getFamilyAttribute(this.value)" required>
                            <option value="">Select Product Family</option>
                            @foreach ($families as $value)
                                <option value="{{ $value->id }}"
                                    {{ old('family_id') == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group">
                        <strong>Category:</strong>
                        <input type="hidden" name="category_id" id="category_id" required>
                        <div id="jstree">

                        </div>

                    </div>

                    <div class="form-group">
                        <strong>Size:</strong>
                        <input class="form-control" name="size" type="text"
                            value="" required>
                    </div>
                    
                    <div class="form-group">
                        <strong>Color:</strong>
                        <input class="form-control" name="color" type="text"
                            value="" required>
                    </div>
                    <div class="form-group">
                        <strong>Brand:</strong>
                        <input type="text" name="brand" id="brand" class="form-control">


                    </div>
                    <div class="form-group">
                        <strong>Product Availability Pincode:</strong>
                        <br />
                        <select name="pincode_availability[]" class="form-control duallistbox" multiple="multiple"
                            data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;"
                            required>
                            @foreach ($pincodes as $value)
                                <option value="{{ $value->id }}"
                                    {{ old('pincode_availability') == $value->id ? 'selected' : '' }}>
                                    {{ $value->pincode }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <strong>Product Quantity Restrictions:</strong><br>
                        <input type="checkbox" id="restrictions" name="restrictions" checked data-toggle="toggle"
                            data-on="Enabled" data-off="Disabled" data-onstyle="outline-primary"
                            data-offstyle="outline-secondary">
                    </div>
                    <div class="form-group" id="restrictions_quantity_div">
                        <strong>Product Quantity:</strong>
                        <input type="number" id="restrictions_quantity" class="form-control" name="restrictions_quantity">
                    </div>
                    {{-- FOOD FAMILY EXTRA FIELD START --}}
                    {{-- <div id="food_family_field">
                        <div class="form-group form-check-inline">
                            <strong>Product Type:</strong>
                            <label class="form-check-label" style="margin-left:100px;">Veg</label>
                            <input class="form-check-input ml-4" name="product_type" type="radio" value="Veg">
                            <label class="form-check-label" style="margin-left:100px;">Non-Veg</label>
                            <input class="form-check-input ml-4" name="product_type" type="radio" value="NoneVeg">
                            <label class="form-check-label" style="margin-left:100px;">None</label>
                            <input class="form-check-input ml-4" name="product_type" type="radio" value="None" checked>
                        </div>
                    </div> --}}
                    {{-- FOOD FAMILY EXTRA FIELD END --}}

                    {{-- GROCERY FAMILY EXTYRA FIELD START --}}
                    <div id="grocery_family_field">
                    </div>
                    {{-- GROCERY FAMILY EXTYRA FIELD END --}}


                    <div class="form-group">
                        <strong>Product Quantity:</strong>
                        <input type="number" class="form-control" name="product_quantity"
                            value="{{ old('product_quantity') }}" required>
                    </div>
                    <div class="form-group">
                        <strong>Unit Type:</strong>
                        <select name="unit_type" id="" class="form-control">
                            @foreach ($unit_types as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>Unit Value:</strong>
                        <input type="text" class="form-control" name="unit" value="{{ old('unit') }}" required>
                    </div>
                    <div class="form-group">
                        <strong>MRP:</strong>
                        <input type="number" class="form-control" name="mrp" id="mrp"
                            value="{{ old('mrp') }}" required>
                    </div>
                    <div class="form-group">
                        <strong>Is Discount:</strong>
                        <select name="discount_type" id="discount" class="form-control"
                            onchange="sellPriceCalculate(this.value)">
                            <option value="">Select Discount</option>
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>
                    </div>
                    <div class="form-group" id="discount_value_div">
                        <strong>Discount Value:</strong>
                        <input type="number" class="form-control" id="discount_value" name="discount_value">
                    </div>
                    <div class="form-group">
                        <strong>Final Amount:</strong>
                        <input type="number" id="final_amount" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <strong>Product Thumnails:</strong>
                        <input type="file" class="form-control" name="thumnails" required>
                    </div>
                    <div class="form-group">
                        <strong>Sort Descreption:</strong>
                        <textarea name="short_description" id="" class="form-control">{{ old('short_description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <strong>Long Descreption:</strong>
                        <textarea name="long_description" id="" class="form-control">{{ old('long_description') }}</textarea>
                    </div>
                    <div id="attribute_list"></div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-form-label">Product Image</label>
                        </div>
                        <div class="col-lg-6">
                            <input class="form-control" name="product_image[]" type="file">
                        </div>
                        <div class="col-lg-2">
                            <button type="button" name="add" id="add" class="btn btn-success">Add
                                More</button>
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
                            <button type="button" name="add" id="add_video" class="btn btn-success">Add
                                More</button>
                        </div>
                    </div>
                    <div id="videos_field"></div>
                    <div class="form-group">
                        <strong>Status:</strong>
                        <br />
                        <select name="status" class="form-control">
                            @foreach (Helper::getCommonStatus() as $value)
                                <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>

                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
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


            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
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


            $('#food_family_field').hide();

            function getFamilyAttribute(family_id) {
                $('.loader').show();
                if (family_id == 2) {
                    $('#food_family_field').show();
                } else {
                    $('#food_family_field').hide();
                }
                if (family_id == 4) {
                    $('#medicine_family_field').show();
                } else {
                    $('#medicine_family_field').hide();
                }
                if (family_id == 3) {
                    $('#grocery_family_field').show();
                } else {
                    $('#grocery_family_field').hide();
                }
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
                            if (data.data.family_attribute.includes(String(val.id))) {
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
                                                '<label class="form-check-label">' + checkBoxVal
                                                .label +
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
                            }


                        });

                        $('#attribute_list').html(column);
                        $('.duallistbox').bootstrapDualListbox()
                    }
                });
            }

            /**getChildCategory
             * */
            function getChildCategory(parent_id, id, id_2 = 'sub_sub_category_id') {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('subcategory.get') }}',
                    data: {
                        parent_id: parent_id
                    },
                    success: function(data) {
                        $('#' + id).html("");
                        $('#' + id_2).html("");
                        $('#' + id).append("<option value=''>Select One</option>");
                        $.each(data, function(optionKey, optionVal) {
                            $('#' + id).append("<option value=" + optionVal.id + ">" + optionVal.name +
                                "</option>");
                        })
                    }
                });
            }

            // sellingPriceCalculate
            $('#discount_value_div').hide();

            function sellPriceCalculate(discount_type) {

                if (discount_type == "fixed") {
                    $('#discount_value_div').show();
                } else if (discount_type == "percentage") {
                    $('#discount_value_div').show();
                } else {
                    $('#discount_value_div').hide();
                }
                var mrp = $('#mrp').val();
                $('#final_amount').val(mrp);
                $('#discount_value').val(0);
            }

            $('#discount_value').keyup(function() {
                var discount_value = $('#discount_value').val();
                var mrp = $('#mrp').val();
                var discount_type = $('#discount').val();
                if (discount_type == "fixed") {
                    $('#final_amount').val(parseInt(mrp) - parseInt(discount_value));
                } else if (discount_type == "percentage") {

                    var amount = (mrp - (mrp * discount_value) / 100);
                    $('#final_amount').val(amount);


                } else {
                    $('#final_amount').val(mrp);
                }

            });
            $('#mrp').keyup(function() {
                var discount_value = $('#discount_value').val();
                var mrp = $('#mrp').val();
                var discount_type = $('#discount').val();
                if (discount_type == "fixed") {
                    $('#final_amount').val(parseInt(mrp) - parseInt(discount_value));
                } else if (discount_type == "percentage") {

                    var amount = (mrp - (mrp * discount_value) / 100);
                    $('#final_amount').val(amount);


                } else {
                    $('#final_amount').val(mrp);
                }

            });
        </script>
        <script>
            $(function() {
                // 6 create an instance when the DOM is ready
                $('#jstree').jstree({
                    'core': {
                        'data': {
                            url: '{{ route('subcategory.get') }}',
                        }
                    }
                }).on('changed.jstree', function(e, data) {
                    $('#category_id').val(data.node.id);
                });

            });
        </script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    @endpush

@endsection
