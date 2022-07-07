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
                <div class="card-header"><b>Product</b>
                    @can('role-create')
                        <span class="float-right">
                            <a class="btn btn-primary" href="{{ route('product.create') }}">New Product</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    <input type="checkbox" class="selectAll" name="selectAll" id="selectAll"> Select All
                    <br>
                    <form id="selectAllForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="">Status</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach (Helper::getCommonStatus() as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 mt-4">
                                <input type="submit" class="btn btn-primary mt-2" value="update Status">

                            </div>
                        </div>
                    </form>
                    <table class="table table-hover" id="product_table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Sr.</th>
                                <th>Thumnail</th>
                                {{-- <th>Vendor Name</th> --}}
                                <th>Name</th>
                                <th>Category</th>
                                <th>Family</th>
                                <th>Product Quantity</th>
                                <th>Unit Type</th>
                                <th>Unit Value</th>
                                <th>Product Type</th>
                                <th>status</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="productIds"
                                                value="{{ $item->id }}" style="opacity: 1">
                                        </div>
                                    </td>
                                    <td>{{ ++$key }}</td>
                                    <td><img src="{{ url($item->thumnails) }}" alt=""
                                            style="width:50px;"></td>
                                    {{-- <td>{{ $item->user->name }}</td> --}}
                                    <td>{{ $item->name }}</td>
                                    <td>{{ @$item->category->name }}</td>
                                    <td>{{ @$item->family->name }}</td>
                                    <td>{{ $item->product_quantity ? $item->product_quantity : 0 }}</td>
                                    <td>{{ @$item->unit_types->name }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->product_type }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        @can('product-edit')
                                            <a class="btn btn-primary" href="{{ route('product.edit', $item->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('product-delete')
                                            <a href="#"
                                                onclick="javascript:return confirm('Are you sure you want to delete this product?')">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['product.destroy', $item->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $data->render() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#selectAll').click(function() {
                if ($(this).prop("checked") == true) {
                    $('input:checkbox').prop('checked', true);
                } else if ($(this).prop("checked") == false) {
                    $('input:checkbox').prop('checked', false);
                }
            });

            $("#selectAllForm").on('submit', function(e) {
                var ids = []
                $("input:checkbox[name=productIds]:checked").each(function() {
                    ids.push($(this).val());
                });
                var status = $('#status').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('status.update.product') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        ids: ids,
                        status: status
                    },
                    success: function(res) {
                        if (res.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: res.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                location.reload()
                            }, 1000);
                        }
                    }
                });
                //stop form submission
                e.preventDefault();

            });
        </script>
    @endpush
@endsection
