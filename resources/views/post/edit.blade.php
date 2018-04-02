@extends('layouts.main')

@section('content')
    @include('includes.tinyEditor')
    <div id="userPost">
        <div class="container">
            <h3 class="display-4 pt-2">Tell Your Story</h3>
            <div class="row">
                <div class="col-md-4">
                    <img src="{{Auth::user()->photo->photo_path}}" alt="" class="img-fluid img-rounded">
                    @include('includes.form_errors')
                </div>
                <div class="col-md-8 col-sm-12">
                    {!! Form::model($post, ['method'=>'PATCH', 'action'=>['PostsController@update', $post->slug]]) !!}
                    <div class="from-group">
                        {!! Form::label('title', 'Title') !!}
                        {!! Form::text('title', null, ['placeholder' => 'Give an appropriate title','class'=>'form-control']) !!}<br>
                    </div>

                    <div class="from-group">
                        {!! Form::label('body', 'Body') !!}
                        {!! Form::textarea('body', null, ['class'=>'form-control']) !!}<br>
                    </div>

                    <div class="from-group ml-5 float-right">
                        {!! Form::submit('Update Post', ['class'=>'btn btn-success float-right']) !!}
                    </div>
                    {!! Form::close() !!}

                    {!! Form::open(['method'=>'DELETE', 'action'=>['PostsController@destroy', $post->slug]]) !!}
                    <div class="from-group mr-5">
                        {!! Form::submit('Delete Post', ['class'=>'btn btn-danger float-right']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@stop