@extends('layouts.main')

@section('content')
@if(count($users) > 0)
    <div class="row">
        @foreach($users as $user)
        <div class="col-sm-12 col-md-5 card m-2">
            <div class="media wow rubberBand">
                <img class="d-flex mr-3 align-self-start img-thumbnail hidden-md-down" src="{{$user->photo->photo_path}}" width="50%" height="50%">
                <div class="media-body">
                    <h5 class="mt-2"><a href="{{route('user.show', $user->id)}}" class="font-weight-bold">
                        {{$user->name}}
                    </a></h5>
                    <p>Joined at {{$user->created_at->diffForHumans()}}</p>
                    <p>lives at {{$user->location->long_address}}</p>
                    <div id="userID" style="display: none;">{{$user->id}}</div>
                    <button class="btn btn-sm btn-outline-success bottom-align-text float-right mb-3 mr-3" data-toggle="tooltip" title="Add to meeting cart" data-placement="right">
                        Meet Up <i class="fa fa-meetup"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <p class="lead">No Users</p>
@endif
@stop

@section('scripts')
@stop