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
                <div class="card-header"><b>Edit Coupons</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('coupons.index') }}">Coupons</a>
                    </span>
                </div>

                <div class="card-body">
                    {!! Form::model($coupon, ['route' => ['coupons.update', $coupon->id], 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
                    @csrf
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
                        {!! Form::text('min_price', null, ['placeholder' => 'Minimum Price', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <strong>Discount Type:</strong>
                        <select name="discount_type" class="form-control" required
                            onchange="$('#discount_value').val(0);">
                            <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>
                                Percentage</option>
                            <option value="free"> {{ $coupon->discount_type == 'free' ? 'selected' : '' }}Free</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>Discount Value:</strong>
                        <input type="number" name="discount_value" id="discount_value" class="form-control"
                            value="{{ $coupon->discount_value }}">
                    </div>

                    {{-- @foreach ($coupon->coupon_categories as $coupon_categories)
                  
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="col-form-label">Category:</label>
                                <select name="category[]" class="form-control categories_div"
                                    onchange="getProductByCategoryId(this.value)">
                                    @foreach ($categories[0] as $categorygroup)
                                        <optgroup label="{!! $categorygroup['name'] !!}">
                                            <option value="{{ $categorygroup['id'] }}"
                                                {{ $categorygroup['id'] == $coupon_categories->category_id ? 'selected' : '' }}>
                                                {{ $categorygroup['name'] }}</option>
                                            @if (isset($categories[$categorygroup['id']]))
                                                @foreach ($categories[$categorygroup['id']] as $key2 => $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ $item['id'] == $coupon_categories->category_id ? 'selected' : '' }}>
                                                        {{ $item['name'] }}</option>
                                                @endforeach
                                            @endif

                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label">Product:</label>
                                <select name="product[]" class="form-control select2bs4 products_div" multiple="multiple"
                                    data-placeholder="Select a Product" data-dropdown-css-class="select2-purple"
                                    style="width: 100%">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @if (in_array($product->id, explode(',', $coupon_categories->product_id))) selected @endif>{{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group col-md-2">
                        <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                    </div>
                    <div id="dynamic_field"></div> --}}
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
                    <div class="row">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
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
                var html = '<div id="row' + i + '" class="dynamic-added row mt-4">' +
                    '<div class="form-group col-md-4">' +
                    '<select class="form-control" name="category[]">';
                html += $('.categories_div').html();
                html += 'Category ' + i + '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<select class="form-control select2bs4" multiple="multiple" data-placeholder="Select a Product" data-dropdown-css-class="select2-purple" style="width: 100%" name="product[]">';
                html += $('.products_div').html();

                'Product ' + i + '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-2">' +
                    '<button type="button" name="remove" id="' + i +
                    '" class="btn btn-danger btn_remove">Delete</button>' +
                    '</div></div>';
                $('#dynamic_field').append(html);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
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
