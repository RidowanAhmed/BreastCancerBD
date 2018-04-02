@extends('layouts.main')

@section('content')
    <div id="showUserPost">
        <!-- Title -->
        <h1>{{$post->title}}</h1>
        <div class="lead">
            <small>by</small>
            <a href="{{route('user.show', $post->user->id)}}" class="font-weight-bold">
                {{$post->user->name}}
            </a>
            @if(Auth::user()->id !== $post->user->id)
            <div id="userID" style="display: none;">{{$post->user->id}}</div>
            <button id="meeting" class="btn btn-sm btn-success ml-5" data-toggle="tooltip" title="Add to meeting cart" data-placement="right">
                Meet Up <i class="fa fa-meetup"></i>
            </button>
            @endif
            @if(Auth::user()->id === $post->user->id)
            <a href="{{route('stories.edit', $post->slug)}}" class="btn btn-sm btn-primary ml-5" data-toggle="tooltip" title="Click here to edit post" data-placement="left">
                Edit Post <i class="fa fa-pencil"></i>
            </a>
            @endif
        </div>
        <hr>
        <!-- Date/Time -->
        <p><i class="fa fa-clock-o"></i> Posted on {{$post->date($post->created_at)}}</p>
        <hr>
        <!-- Post Content -->
        <p class="text-justify">{!! $post->body !!}</p>
        <hr>
    </div>
    <div id="disqus_thread"></div>
    <script>
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        /*
        var disqus_config = function () {
        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://http-codehacking-dev-2.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

@endsection
@section('scripts')
    <script id="dsq-count-scr" src="//http-codehacking-dev-2.disqus.com/count.js" async></script>
@stop