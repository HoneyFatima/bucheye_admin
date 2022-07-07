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
                <div class="card-header"><b>Create Hot Product</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('hot_products.index') }}">Hot Products</a>
                    </span>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'hot_products.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    
                    
                    <div class="form-group">
                        <strong>Product List:</strong>
                        <br />
                        <select name="product_id[]" class="form-control duallistbox" multiple="multiple"
                            data-placeholder="Select a product" data-dropdown-css-class="select2-purple" style="width: 100%;"
                            required>
                            @foreach ($products as $value)
                                <option value="{{ $value->id }}"@if(in_array($value->id,$hotproducts)) selected @endif>
                                    {{ $value->name }}</option>
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
            
          </script>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
          <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    @endpush

@endsection

