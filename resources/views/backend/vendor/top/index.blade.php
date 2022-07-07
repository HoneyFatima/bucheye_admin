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
                <div class="card-header"><b>Top Vendor</b>
                    @can('role-create')
                        <span class="float-right">
                            <a class="btn btn-primary" href="{{ route('top-sellers.create') }}">New Top Vendor</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    
                    <table class="table table-hover" id="product_table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sr.</th>
                                <th>Thumnail</th>
                                <th>Vendor Name</th>
                                <th>Vendor Name</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($top_sellers as $key => $item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td><img src="{{ url($item->users->profile_image) }}" alt=""
                                            style="width:50px;"></td>
                                    <td>{{ $item->users->name }}</td>
                                    <td>{{ $item->users->name }}</td>
                                    <td>
                                    @can('top-sellers-delete')
                                        <a href="#"
                                            onclick="javascript:return confirm('Are you sure you want to delete this top sellers?')">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['top-sellers.destroy', $item->id], 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                            {!! Form::close() !!}
                                        </a>
                                    @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $top_sellers->render() }}
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
