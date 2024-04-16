var map;
var geocoder;
var infowindow;
var marker;
var circle;

function initMap2(lat, lng) {
    var lat = 41.752186516519075;
    var lng = 44.78002449599475;
    map = new google.maps.Map(document.getElementById('main_map'), {
        center: {
            lat: lat,
            lng: lng
        },
        zoom: 12
    });

    marker = new google.maps.Marker({
        map: map
    });
    marker.setVisible(true);

    $(document).ready(function() {
        $('#locationsTable tbody tr').on('click', function() {
            var lat = $(this).data('lat');
            var lng = $(this).data('lng');
            var radius = $(this).data('radius');
            map.panTo(new google.maps.LatLng(lat, lng));
            setPlaceOnMap(lat, lng);
            removeCircles();

            circle = new google.maps.Circle({
                map: map,
                radius: radius,
                fillColor: '#AA0000',
                fillOpacity: 0.2,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2
            });

            circle.bindTo('center', marker, 'position');
        });
    });
}

function removeCircles() {
    if (circle) {
        circle.setMap(null);
        circle = null;
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
        browserHasGeolocation ?
        "Error: The Geolocation service failed." :
        "Error: Your browser doesn't support geolocation."
    );
    infoWindow.open(map);
}

function setPlaceOnMap(lat, lng) {
    var latLng = new google.maps.LatLng(lat, lng);
    marker.setPosition(latLng);
    map.setCenter(latLng);
    map.setZoom(17);
}
$(function() {
    initMap2(lat, lng);
})