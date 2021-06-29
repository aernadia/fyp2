@extends('admin.layouts.dashboard')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Title: {{ $post['title'] }}</h1>
        </div>
        <div class="card-body" >
            <h5 class="card-title">Student Name: </h5>
            <p>{{$post->user['name']}}</p>
        </div>
    
        <div class="card-body" >
            <h5 class="card-title">Content: </h5>
            <p>{!!$post->content!!}</p>
        </div>
    </div>
    <div class="row pull-right mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-lg float-md-right" role="button" aria-pressed="true">Go Back</a>
    </div>
    
    
</div>

@endsection