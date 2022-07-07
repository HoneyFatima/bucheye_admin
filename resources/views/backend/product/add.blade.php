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
                                <option value="{{ $value->id }}" {{ old('family_id') ==  $value->id ? "selected" : ""}}>{{ $value->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div id="attribute_list"></div>
                    <div class="form-group">
                        <strong>Category:</strong>
                        <select class="form-control" name="category_id">
                            @foreach ($categories[0] as $categorygroup)
                                <optgroup label="{!! $categorygroup['name'] !!}">
                                    <option value="{{ $categorygroup['id'] }}" value="{{ old('category_id') ==  $value->id ? "selected" : ""}}">{{ $categorygroup['name'] }}</option>
                                    @if (isset($categories[$categorygroup['id']]))
                                        @foreach ($categories[$categorygroup['id']] as $key2 => $item)
                                            <option value="{{ $item['id'] }}" value="{{ old('category_id') ==  $value->id ? "selected" : ""}}">{{ $item['name'] }}</option>
                                        @endforeach
                                    @endif

                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>Product Availability Pincode:</strong>
                        <br />
                        <select name="pincode_availability[]" class="form-control duallistbox" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                            @foreach ($pincodes as $value)
                                <option value="{{ $value->id }}" {{ old('pincode_availability') ==  $value->id ? "selected" : ""}}>{{ $value->pincode }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group form-check-inline">
                        <strong>Product Type:</strong>
                        <label class="form-check-label" style="margin-left:100px;">Veg</label>
                        <input class="form-check-input ml-4" name="product_type" type="radio" value="Veg">
                        <label class="form-check-label" style="margin-left:100px;">Non-Veg</label>
                        <input class="form-check-input ml-4" name="product_type" type="radio" value="NoneVeg">
                        <label class="form-check-label" style="margin-left:100px;">None</label>
                        <input class="form-check-input ml-4" name="product_type" type="radio" value="None" checked>
                    </div>
                    <div class="form-group">
                        <strong>Unit Type:</strong>
                        <input type="text" class="form-control" name="unit_type" value="{{ old('unit_type') }}" required>
                    </div>
                    <div class="form-group">
                        <strong>Unit Value:</strong>
                        <input type="text" class="form-control" name="unit" value="{{ old('unit') }}" required>
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
                                <option value="{{ $value }}" {{ old('status') == $value ? "selected" : ""}}>{{ $value }}</option>
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
                        $.each(data.attributes, function(key, val) {
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
                        $('.duallistbox').bootstrapDualListbox()
                    }
                });
            }

        </script>
    @endpush
@endsection
