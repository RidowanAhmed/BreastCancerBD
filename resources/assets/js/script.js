import * as bootbox from "../../../node_modules/bootbox/bootbox.min";

try {
    window.$ = window.jQuery = require('jquery');
    require('tether');
    require('bootstrap');
} catch (e) {}
import { WOW } from 'wowjs';
window.WOW = WOW;
let map, marker, infoWindow, geocoder, place, place_id, dateTime;
let pos = {
    lat: 23.8156385 ,
    lng: 90.4248177
};
$(document).ready(function(){
    // $('[data-toggle="tooltip"]').tooltip();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#meeting').on('click',function(e){
        e.preventDefault();
        console.log(e);
        $.ajax({
            url: '/meeting',
            dataType : 'text',
            type: 'POST',
            data: {
                'id' : $(this).prev().html(),
            },
            success:function(response) {
                bootbox.alert(response);
            },
            error: function(e){
                console.log(e.message);
                bootbox.alert('Something wrong. Please try again later');
            }
        });
    });

    $('div.alert .close').on('click', function() {
        let e = $(this);
        $.ajax({
            url: '/meeting',
            dataType : 'text',
            type: 'POST',
            data: {
                'name' : e.siblings('a').eq(0).children('strong').text(),
            },
            success:function(response) {
                e.parent().alert('close');
                // console.log(response);
                bootbox.alert({
                    message: response,
                    backdrop: true
                });
            },
            error: function(response){
                // console.log(response.responseText);
                bootbox.alert({
                    message: 'Something wrong. Please try again later',
                    backdrop: true
                });
            }
        });
    });

    $('#meetingButton').on('click', function(e) {
        e.preventDefault();
        dateTime = $('#pickTime').val();
        if(dateTime === "" || place === "" || place == null){
            bootbox.alert({
                message: 'Meeting Time & Place must be set',
                backdrop: true
            });
        } else {
            bootbox.confirm({
                title: "Send e-mail?",
                message: "Do you want to send meeting information to all selected users now? This cannot be undone.",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if(result) {
                        $.ajax({
                            url: '/meeting/set',
                            dataType : 'json',
                            type: 'POST',
                            data: {
                                'id' :       $('#userId').text(),
                                'dateTime' : dateTime,
                                'place'    : place,
                                'place_id'    : place_id
                            },
                            success:function(response) {
                                // console.log(response);
                                // return;
                                bootbox.alert({
                                    message: 'All uses have been notified about Meeting Time & Place',
                                    backdrop: true
                                });
                            },
                            error: function(response){
                                // console.log(response);
                                // return;
                                bootbox.alert({
                                    message: 'Something wrong. Please try again later',
                                    backdrop: true
                                });
                            }
                        });
                    }
                }
            });
        }

    });

    $('#deleteButton').on('click',function(e){
        e.preventDefault();
        bootbox.confirm({
            title: "Delete Account?",
            message: "Do you really want to delete your account. All your data will be destroyed. This process is un-reversible",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function (result) {
                if (result)
                    $('#deleteForm')[0].submit();
            }
        });
    });

});
window.initMap = function() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 23.8156385,
            lng: 90.4248177
        },
        zoom: 14
    });
    infoWindow = new google.maps.InfoWindow;
    geocoder = new google.maps.Geocoder;
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            pos.lat = position.coords.latitude;
            pos.lng = position.coords.longitude;
            setLocationOnMap();

        }, function () {
            setLocationOnMap();
            // handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
    $.ajax({
        url: '/meeting/create',
        dataType : 'json',
        type: 'GET',
        success:function(response) {
            response.forEach(function(entry) {
                let mark = new google.maps.Marker({
                    position: entry.position,
                    map: map,
                    title: entry.address
                });
                let infWindow = new google.maps.InfoWindow({
                    content: entry.name
                });
                infWindow.open(map, mark);
            });
        },
        error: function(e){
            console.log(e.message);
        }
    });
};

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}

function setLocationOnMap() {
    placeMarker(pos, map);
//    marker.addListener('click', toggleBounce);

    map.addListener('click', function(e) {
        placeMarker(e.latLng, map);
    });
    // setTimeout(function () {
    //     infoWindow.close();
    //     toggleBounce();
    // }, 5000);
}

function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}
function placeMarker(position, map) {
    if (marker && marker.setMap) {
        marker.setMap(null);
    }
    marker = new google.maps.Marker({
        position: position,
        map: map,
        animation: google.maps.Animation.DROP,
        title: 'Location'
    });
    infoWindow.setPosition(pos);
    infoWindow.open(map, marker);
    map.setCenter(pos);
    geocoder.geocode({'location': position}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                place = results[0].formatted_address;
                place_id = results[0].place_id;
                // console.log(place_id);
                infoWindow.setContent(place);
                marker.setTitle(place);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
    map.panTo(position);
}
