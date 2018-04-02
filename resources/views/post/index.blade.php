@extends('layouts.main')

@section('content')
    <div id="userPost">
        <div class="row">
            @if(count($posts) > 0)
                @foreach($posts as $post)
                <div class="col-sm-12 col-md-5 card m-2">
                    <div class="media wow rubberBand">
                        <img class="d-flex mr-3 align-self-start img-thumbnail img-fluid hidden-md-down" src="{{$post->imageSrc()}}" alt="No Image">
                        <div class="media-body" style="overflow: hidden;">
                            <h5 class="display-6 mt-2">{{$post->title}}</h5>
                            <p>
                                <small>{{$post->created_at->diffForHumans()}} by <sub>{{$post->user->name}}</sub></small>
                                @if($post->user->role->id == 1)
                                    <i class="fa fa-wheelchair"></i>
                                @else
                                    <i class="fa fa-user-md"></i>
                                @endif
                            </p>
                            <hr>
                            <p>{!! str_limit(preg_replace("/[^A-Za-z0-9., ]/", '', strip_tags($post->body)),60) !!}</p>
                            <a href="{{route('stories.show', $post->slug)}}" class="btn btn-outline-success btn-sm bottom-align-text float-right mb-2 mr-2">Read More</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                {{'No Stories'}}
            @endif
        </div>

        <div id="pagi">
            {{$posts->render("pagination::bootstrap-4")}}
        </div>

    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        new WOW().init();
    });
</script>
@stop