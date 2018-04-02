@extends('layouts.main')

@section('content')
<div id="userProfile">
    <div class="row mt-5">

        <div class="col-md-5">
            {!! Form::model($user, ['method'=>'PATCH', 'action'=>['UsersController@update', $user->id], 'files'=>true]) !!}
            <img src="{{$user->photo->photo_path}} " alt="Image" class="img-fluid img-thumbnail rounded-circle mb-4">
            <div class="from-group mt-4">
                {!! Form::label('photo_id', 'Upload Image') !!}
                {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}<br>
            </div>
        </div>

        <div class="col-md-7 mt-5">
            <div class="input-group" id="addonName">
                <i class="input-group-addon fa fa-user"></i>
                {!! Form::text('name', null, ['placeholder'=>'Full Name','class'=>'form-control','aria-describedby'=>'addonName']) !!}
            </div><br>
            <div class="input-group" id="addonEmail">
                <i class="input-group-addon fa fa-envelope"></i>
                {!! Form::email('email', null, ['placeholder'=>'email address','class'=>'form-control','aria-describedby'=>'addonEmail']) !!}
            </div><br>
            <hr>
            <div class="from-group">
                {!! Form::label('is_shareable', 'Share Personal Info ?') !!} <i class="fa fa-bullhorn"></i> <br>
                Yes
                {!! Form::radio('is_shareable',1,false) !!}
                No
                {!! Form::radio('is_shareable',0,true) !!}
            </div>
            <div class="input-group" id="addonPhone">
                <i class="input-group-addon fa fa-volume-control-phone"></i>
                {!! Form::text('phone_num', null,['placeholder'=>'Contact number' , 'maxlength'=>'11', 'class'=>'form-control','aria-describedby'=>'addonPhone']) !!}
            </div><br>
            <div class="input-group" id="addonLocation">
                <i class="input-group-addon fa fa-address-card"></i>
                {!! Form::text('long_address', null,['id'=>'address','placeholder'=>'Click here to add address','class'=>'form-control','aria-describedby'=>'addonLocation']) !!}
            </div><br>
            {!! Form::hidden('short_address',null,['id'=>'shortAddress']) !!}
            {!! Form::hidden('long_address',null,['id'=>'longAddress']) !!}
            {!! Form::hidden('position',null,['id'=>'positionCords']) !!}

            <div class="from-group ml-5 float-right">
                {!! Form::submit('Update Info', ['class'=>'btn btn-success float-left']) !!}
            </div>
            {!! Form::close() !!}

            {!! Form::open(['id'=>'deleteForm','method'=>'DELETE','action'=>['UsersController@destroy', $user->id]]) !!}
            <div class="from-group mr-5">
                {!! Form::submit('Delete Account', ['id'=>'deleteButton','class'=>'btn btn-danger float-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3e5bENsrIY1jYIIMBtvbNwzOhT45zTec">
</script>
<script type="text/javascript">
$(document).ready(function(){
    let input_long_address =  $('#address');
    input_long_address.on('click',function(){
        getLocation();
        input_long_address.off('click');
    });
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log('nope');
        }
        function showPosition(position) {
            let geocoder = new google.maps.Geocoder;
            let pos = {
                lat: position.coords.latitude ,
                lng: position.coords.longitude
            };
            geocoder.geocode({'location': pos}, function(results, status) {
                if (status === 'OK') {
                    input_long_address.prop('disabled', true);
                    short_address = results[0].formatted_address;
                    long_address = results[2].formatted_address;
                    input_long_address.val(long_address);
                    $('#shortAddress').val(short_address);
                    $('#longAddress').val(long_address);
                    $('#positionCords').val(JSON.stringify(pos));
                } else {
                    console.log('Geocoder failed due to: ' + status);
                }
            });
        }
    }
});
</script>
@stop

