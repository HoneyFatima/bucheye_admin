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
                <div class="card-header"><b>Coupons</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('coupons.index') }}">Coupons</a>
                    </span>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'coupons.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <strong>Code:</strong>
                        {!! Form::text('code', null, ['placeholder' => 'Code', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <strong>Minimum Price:</strong>
                        {!! Form::number('min_price', null, ['placeholder' => 'Minimum Price', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <strong>Discount Type:</strong>
                        <select name="discount_type" class="form-control" required
                            onchange="$('#discount_value').val(0);">
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                            <option value="free">Free</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>Discount Value:</strong>
                        <input type="number" name="discount_value" id="discount_value" class="form-control" value="0"> 
                    </div>
                        {{-- <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Category:</label>
                                <select class="form-control" name="category[]"
                                    onchange="getProductByCategoryId(this.value)">
                                    @foreach ($categories[0] as $categorygroup)
                                        <optgroup label="{!! $categorygroup['name'] !!}">
                                            <option value="{{ $categorygroup['id'] }}">
                                                {{ $categorygroup['name'] }}</option>
                                            @if (isset($categories[$categorygroup['id']]))
                                                @foreach ($categories[$categorygroup['id']] as $key2 => $item)
                                                    <option value="{{ $item['id'] }}">
                                                        {{ $item['name'] }}</option>
                                                @endforeach
                                            @endif

                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Product:</label>
                                <select name="product[]" id="product" class="form-control select2bs4" multiple="multiple"
                                    data-placeholder="Select a Product" data-dropdown-css-class="select2-purple"
                                    style="width: 100%">

                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group col-md-2">
                            <button type="button" name="add" id="add" class="btn btn-success">Add
                                More</button>
                        </div>
                        <div id="dynamic_field"></div>
                        <div class="form-group">
                            <strong>Maximum Discount:</strong>
                            {!! Form::text('max_discount', null, ['placeholder' => 'Maximum Discount', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <strong>Expiry Date:</strong>
                            {!! Form::date('expiry_date', null, ['placeholder' => 'Expiry Date', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <strong>Description:</strong>
                            {!! Form::text('description', null, ['placeholder' => 'Description', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <strong>Term Condition:</strong>
                            {!! Form::text('term_condition', null, ['placeholder' => 'Term Condition', 'class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label name="status">Status:</label>
                            <select class="form-control" name="status" required>
                                @foreach (Helper::getCommonStatus() as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
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
                var i = 1;
                $('#add').click(function() {
                    i++;
                    $('#dynamic_field').append(
                        '<div id="row' + i + '" class="dynamic-added row mt-4">' +
                        '<div class="form-group col-md-4">' +
                        '<select class="form-control" name="category">Category ' + i + '</select>' +
                        '</div>' +
                        '<div class="form-group col-md-4">' +
                        '<select class="form-control" name="product">Product ' + i + '</select>' +
                        '</div>' +
                        '<div class="form-group col-md-2">' +
                        '<button type="button" name="remove" id="' + i +
                        '" class="btn btn-danger btn_remove">Delete</button>' +
                        '</div></div>'
                    );
                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });

                function getProductByCategoryId(category_id) {
                    $.ajax({
                        url: "{{ url('admin/getProductByCategoryId') }}",
                        type: 'GET',
                        data: {
                            category_id: category_id
                        },
                        success: function(result) {

                            $('#product').html('');
                            $.each(result, function(key, val) {
                                $('#product').append('<option value="' + val.id + '">' + val.name +
                                    '</option>');
                            });
                        },
                        error: function(error) {
                            console.log(error.status)
                        }
                    });
                }
            </script>
        @endpush
    @endsection
