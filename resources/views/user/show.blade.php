@extends('layouts.main')

@section('content')
    <div id="userProfile">
        <div class="row mt-5">
            <div class="col-sm-12 col-md-5">
                <img src="{{$user->photo->photo_path}} " alt="Image" class="img-fluid img-thumbnail rounded-circle mb-4">
            </div>
            <div class="col-sm-12 col-md-7">
                <table class="table table-hover img-thumbnail mt-5">
                    <tbody>
                    <tr>
                        <th scope="row"><i class="fa fa-user-o"></i></th>
                        <td>{{$user->name}} <small>joined</small>   {{$user->created_at->diffForHumans()}}</td>
                    </tr>
                    <tr>
                        <th scope="row"><i class="fa fa-envelope-open-o"></i></th>
                        <td>{{$user->email}}</td>
                    </tr>
                    @if($user->is_shareable)
                    <tr>
                        <th scope="row"><i class="fa fa-bullhorn"></i></th>
                        <td>{{$user->location->phone_num}}</td>
                    </tr>
                    <tr>
                        <th scope="row"><i class="fa fa-address-card-o"></i></th>
                        <td>{{$user->location->short_address}}</td>
                    </tr>
                    @else
                    <tr>
                        <th scope="row"><i class="fa fa-bullhorn"></i></th>
                        <td>User isn't comfortable to share personal information</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection