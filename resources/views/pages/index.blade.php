@extends('layout')

@section('style')
    <style>
        html, body{
            background-color: antiquewhite;
        }
    </style>
@endsection

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <h4 class="card-title">Laravel CRUD</h4>
            <div class="row mb-3">
                <div class="col-md-12">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalAdd">Post</button>
                </div>
            </div>
            
            @if( \Session::has('success') )
                <div class="alert alert-success" role="alert">
                    <strong>{{  \Session::get('success') }}</strong>
                </div>
            @endif

            @foreach ($blogs as $blog)
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="card-title">{{$blog->title}}</h4>
                        <p class="card-text">{{$blog->body}}</p>
                        <p class="text-right">
                            <button class="btn btn-link editBtn" data-id="{{$blog->id}}" data-title="{{$blog->title}}" data-body="{{$blog->body}}">Edit</button>
                            <a href="{{ route('blog.destroy', $blog->id ) }}" onclick="return confirm('Do you want to delete these record?')" class="btn btn-link delBtn">Delete</a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="">
                                {{-- <small id="helpId" class="form-text text-danger">Help text</small> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control"></textarea>
                                {{-- <small id="helpId" class="form-text text-danger">Help text</small> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Add -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title_edit">Title</label>
                                <input type="text" class="form-control" name="title_edit" id="title_edit" aria-describedby="helpId" placeholder="">
                                {{-- <small id="helpId" class="form-text text-danger">Help text</small> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body_edit">Body</label>
                                <textarea name="body_edit" id="body_edit" cols="30" rows="10" class="form-control"></textarea>
                                {{-- <small id="helpId" class="form-text text-danger">Help text</small> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnUpdate">Update</button>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('js')
    <script>
        $(document).ready(function(){

            $("#btnSave").on('click',function(){
                $.ajax({
                    type: 'post',
                    url: '{{ route("blog.store") }}',
                    headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    data:{
                        title: $("#title").val(),
                        body: $("#body").val()
                    },
                    success: function( res ){
                        location.reload()
                    },
                    error: function( res ){
                        console.log('Erorr: ' + res)
                    }
                })
            })


            $(".editBtn").click(function(){
                var id = $(this).attr('data-id');
                // var title = $(this).attr('data-title');
                // var body = $(this).attr('data-body');

                // $("#title_edit").val(title)
                // $("#body_edit").val(body)

                $.ajax({
                    type: 'get',
                    url: 'blog/'+ id +'/edit',
                    success: function( res ){
                        $("#title_edit").val(res.title)
                        $("#body_edit").val(res.body)
                        $("#btnUpdate").attr('data-id', res.id)
                    },
                    error: function( res ){
                        console.log('Erorr: ' + res)
                    }
                })


                $("#modalEdit").modal('show')
            })


            $("#btnUpdate").click(function(){
                var id = $(this).attr('data-id');

                $.ajax({
                    type: 'put',
                    url: 'blog/'+id,
                    headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    data:{
                        title: $("#title_edit").val(),
                        body: $("#body_edit").val()
                    },
                    success: function( res ){
                        location.reload()
                    },
                    error: function( res ){
                        console.log('Erorr: ' + res)
                    }
                })
            })

        });
    </script>
@endsection