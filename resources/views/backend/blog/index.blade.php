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
                <div class="card-header"><b>Blogs</b>
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('blog.create') }}">New Blogs</a>
                    </span>
                </div>

                @foreach ($blogs as $key => $blog)
                    <div class="card mb-3">
                        <img src="{{ url($blog->image ? $blog->image : '') }}" class="card-img-top" alt="Card image cap"
                            style="height:300px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $blog->title }}</h5>
                            <p class="card-text">{!! $blog->short_description !!}</p>
                            @can('manage-blog-edit')
                                <a class="btn btn-primary" href="{{ route('blog.edit', $blog->id) }}"><i
                                        class="fas fa-edit"></i></a>
                            @endcan
                            @can('manage-blog-delete')
                                <a href="#" onclick="javascript:return confirm('Are you sure you want to delete this blog?')">
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $blog->id], 'style' => 'display:inline']) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
                                    {!! Form::close() !!}
                                </a>
                            @endcan
                            <button type="button" class="btn btn-info" onclick="getCommentById({{ $blog->id }})"
                                style='margin-right:16px'>
                                View Comment
                            </button>
                            @php
                                $like = array_column($blog->comment->where('is_like', 1)->toArray(), 'is_like');
                                $dislike = array_column($blog->comment->where('is_like', 2)->toArray(), 'is_like');
                            @endphp
                            <i class='fas fa-thumbs-up fa-2x' style="color:blue;" fa-2x
                                aria-hidden="true">{{ count($like) }}</i>
                            <i class='fas fa-thumbs-down fa-2x' style="color:red;"
                                aria-hidden="true">{{ count($dislike) }}</i>
                        </div>
                    </div>
                @endforeach
                <div class="modal fade" id="modal-xl">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Comments</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <table class="table" id="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Comment</th>
                                                    <th>Created Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @push('scripts')
                <script>
                    function getCommentById(blog_id) {
                        AmagiLoader.show();
                        setTimeout(() => {
                            AmagiLoader.hide();
                        }, 300);
                        $.ajax({
                            url: "{{ url('admin/getCommentById') }}",
                            type: 'GET',
                            data: {
                                blog_id: blog_id
                            },
                            success: function(result) {
                                $('#table').dataTable().fnClearTable();
                                $('#table').dataTable().fnDestroy();
                                $.each(result, function(key, val) {
                                    $('#table  > tbody').append('<tr><td>' + val.users.name + '</td><td>' + val
                                        .comment + '</td><td>' + val.created_at + '</td></tr>');
                                });
                                $('#modal-xl').modal('show');
                            },
                            error: function(error) {
                                console.log(error.status)
                            }
                        });
                    }
                </script>
            @endpush
        @endsection
