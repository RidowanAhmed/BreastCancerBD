@extends('layouts.main')

@section('content')
@include('includes.tinyEditor')
<div id="userPost">
    <div class="container">
        <h3 class="display-4 pt-2">Tell Your Story</h3>
        <div class="row">
            <div class="col-md-4">
                <img src="{{$user->photo->photo_path}}" alt="" class="img-fluid img-rounded">
                @include('includes.form_errors')
            </div>
            <div class="col-md-8 col-sm-12">
                {!! Form::open(['method'=>'POST', 'action'=>'PostsController@store']) !!}
                <div class="from-group">
                    {!! Form::label('title', 'Title') !!}
                    {!! Form::text('title', null, ['placeholder' => 'Give an appropriate title','class'=>'form-control']) !!}<br>
                </div>

                <div class="from-group">
                    {!! Form::label('body', 'Body') !!}
                    {!! Form::textarea('body', null, ['class'=>'form-control']) !!}<br>
                </div>

                <div class="from-group">
                    {!! Form::submit('Create Post', ['class'=>'btn btn-primary float-right mr-5']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

@stop