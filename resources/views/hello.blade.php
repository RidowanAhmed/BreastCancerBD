@extends('layouts.main')
@section('stylesheet')
<style>
    #myVideo {
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        min-height: 100%;
        min-width: 100%;

    }
</style>
@stop
@section('content')
    <video autoplay muted loop id="myVideo">
        <source src="{{asset('videos/BreastCancer.webm')}}" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
@stop
@section('scripts')
<script>
    let video = document.getElementById("myVideo");
    let btn = document.getElementById("myBtn");
    function myFunction() {
        if (video.paused) {
            video.play();
            btn.innerHTML = "Pause";
        } else {
            video.pause();
            btn.innerHTML = "Play";
        }
    }
</script>
@stop
