@extends('admin.layouts.dashboard')

@section('content')

<h1>Update Application</h1>

{{-- @canany(['isAdmin'])
<div class="publish-checkbox" style="float:right">
    <label for="publish-post">Approve ?</label>
    <input type="checkbox" id="publish-post" {{$post->published ? 'checked=checked' : '' }}>
</div>
@endcanany --}}
@canany(['isSupervisor'])
{{-- <div class="publish-checkbox" style="float:right">
    <label for="publish-post">Approve ?</label>
    <input type="checkbox" id="publish-approve" {{$post->published ? 'checked=checked' : '' }}>
</div>
<div class="publish-checkbox" style="float:right">
    <label for="publish-post">Rejected ?</label>
    <input type="checkbox" id="publish-rejected" {{$post->published ? 'checked=checked' : '' }}>
</div>
<div class="publish-checkbox" style="float:right">
    <label for="publish-post">Pending ?</label>
    <input type="checkbox" id="publish-pending" {{$post->published ? 'checked=checked' : '' }}>
</div> --}}
<form method="POST" action="/posts/{{ $post->id }}" enctype="multipart/form-data">
    @method('PATCH')
    @csrf()
    <label for="published">Choose:</label>
            <select name="published" class="form-control" style="width:250px">
                 {{-- <option value="0" selected>--- Select Number ---</option> --}}
                <option value="1" {{$post->published==1 ? 'selected' : ''}}>Approved</option>
                <option value="2" {{$post->published==2 ? 'selected' : ''}}>Rejected</option>
                <option value="0" {{$post->published==0 ? 'selected' : ''}}>Pending</option>
     
            </select>
@endcanany

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> 
            @endforeach
        </ul>
    </div>
@endif


    
    {{-- <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Title..." value="{{ $post->title }}">
    </div> --}}
    {{-- <label for="image">Select Image</label>
    <input type="file" name="image" class="form-control-file" id="profile-img" value="{{$post->image}}">
    <div class="row">
        <img src="{{ asset('/storage/images/posts_images/'.$post->image_url) }}" id="profile-img-tag" class="img-thumbnail mx-auto" alt="{{$post->image_url}}" width="250" >
    </div> --}}
    {{-- <div class="form-group">
        <label for="content">Insert Content</label>
        <textarea name="post_content" id="content">{{ $post->content }}</textarea>
    </div> --}}

    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>

@section('js_post_page')

    <script>
        
        

        $(document).ready(function(){    
            $('#publish-approve').on('click', function(event) {
                // event.preventDefault();

                if ($("#publish-approve").is(":checked")){
                    var checked = 1;
                }
                $.ajax({
                    url: "/posts/{{$post->id}}",
                    method: 'get',
                    dataType: 'json',
                    data: {
                        task: {
                            id: "{{$post->id}}",
                            checked: checked
                        }
                    }
                }).done(function(data) {
                    console.log(data);
                });
            });
            $('#publish-rejected').on('click', function(event) {
                // event.preventDefault();

                if ($("#publish-rejected").is(":checked")){
                    var checked = 0;
                }
                $.ajax({
                    url: "/posts/{{$post->id}}",
                    method: 'get',
                    dataType: 'json',
                    data: {
                        task: {
                            id: "{{$post->id}}",
                            checked: checked
                        }
                    }
                }).done(function(data) {
                    console.log(data);
                });
            });
            $('#publish-pending').on('click', function(event) {
                // event.preventDefault();

                if ($("#publish-pending").is(":checked")){
                    var checked = 0;
                }
                $.ajax({
                    url: "/posts/{{$post->id}}",
                    method: 'get',
                    dataType: 'json',
                    data: {
                        task: {
                            id: "{{$post->id}}",
                            checked: checked
                        }
                    }
                }).done(function(data) {
                    console.log(data);
                });
            });
            
        });


    </script>
    
@endsection

@endsection