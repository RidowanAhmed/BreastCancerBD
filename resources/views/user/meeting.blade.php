@extends('layouts.main')
@section('stylesheet')
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <style>
        #map {
            min-width: 100%;
            height: 500px;
            background-color: grey;
        }
    </style>
@stop
@section('content')
<h3 class="display text-center mt-2 hidden-md-down">Set a Meeting</h3>
<span id="userId"  style="display: none;">{{Auth::user()->id}}</span>
<div id="upperSection" class="row mt-1">
    <div class='col-md-4 col-sm-12 wow bounceInDown'>
        <div class="form-group">
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' id="pickTime" class="form-control"/>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
        @if(count($users) > 0)
        <div class="img-thumbnail">
            @foreach($users as $user)
            <div class="alert alert-success">
                <button type="button" class="close" aria-hidden="true">&times;</button>
                <a href="{{route('user.show', $user->id)}}"><strong>{{$user->name}}</strong></a>
            </div>
            @endforeach
        </div>
        @else
            <p class="lead">Your haven't added any user. Read their story to add them in the meeting queue</p>
        @endif
    </div>
    <div id="goggleMap" class="col-md-8 col-sm-12 wow bounceInUp img-thumbnail">
        <div id="map"></div>
    </div>
</div>
@if(count($users) > 0)
<div id="lowerSection" class="row mt-4">
    <div class="col text-center">
        <div class="form-group">
            <button id="meetingButton" class="btn btn-success">Submit</button>
        </div>
    </div>
</div>
@endif
@stop
@section('scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3e5bENsrIY1jYIIMBtvbNwzOhT45zTec&callback=initMap">
</script>
<script type="text/javascript">
$(document).ready(function(){
    new WOW().init();
    $('#datetimepicker1').datetimepicker();


});
</script>

@stop
