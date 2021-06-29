@extends('admin.layouts.dashboard')

@section('content')

<h1><center>APPLY FORM<center></h1>
<br>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> 
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/posts" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    <div class="form-group">
        <label for="title">Title of Proposed Project</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Title..." value="{{ old('title') }}">
        <input type="hidden" name="svId" class="form-control" id="svId" value="{{ $svId }}">

    </div>
    <div class="form-group">
        <label for="studId">Student ID</label>
        <input type="text" name="studId" class="form-control" id="studId" placeholder="Student ID.." value="{{ old('studId') }}">
    </div>
    <div class="form-group">
        <input type="file" name="file">
    </div>
    <div class="form-group">
        <label for="content">Insert Description</label>
        <textarea name="post_content" id="content">{{ old('post_content') }}</textarea>
    </div>
    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" name="date" class="form-control" >
    </div>

    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>

<script>
    CKEDITOR.replace( 'post_content' );
</script>

@endsection