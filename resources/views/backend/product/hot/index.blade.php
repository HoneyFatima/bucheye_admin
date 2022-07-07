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
                            <a class="btn btn-primary" href="{{ route('hot_products.create') }}">New Hot Product</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    
                    <table class="table table-hover" id="product_table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sr.</th>
                                <th>Thumnail</th>
                                <th> Product Name</th>
                                <th>Vendor Name</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td><img src="{{ url($item->product->thumnails) }}" alt=""
                                            style="width:50px;"></td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->product->user->name }}</td>
                                    <td>
                                    @can('product-delete')
                                        <a href="#"
                                            onclick="javascript:return confirm('Are you sure you want to delete this product?')">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['hot_products.destroy', $item->id], 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                            {!! Form::close() !!}
                                        </a>
                                    @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $products->render() }}
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
