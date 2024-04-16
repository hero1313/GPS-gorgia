var map, marker, infowindow, geocoder;

function initMapr(lat, lng) {
    map = new google.maps.Map(document.getElementById('add_map'), {
        center: {
            lat: 42.053372,
            lng: 44.170532
        },
        zoom: 7
    });


    geocoder = new google.maps.Geocoder();
    var input = document.getElementById('pac_input');
    console.log(input)
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    marker = new google.maps.Marker({
        map: map
    });

   
    marker.setVisible(true);

    map.addListener('click', function(e) {
        var lat = e.latLng.lat();
        var lng = e.latLng.lng();
        map.panTo(new google.maps.LatLng(lat, lng));
        setPlaceOnMap(lat, lng);
    });

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

    $('#lat').val(lat);
    $('#lng').val(lng);

    geocoder
        .geocode({
            location: {
                lat: lat,
                lng: lng
            }
        })
        .then((response) => {
            if (response.results[1]) {
                var place = response.results[1];
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(12);
                }
                marker.setPosition(place.geometry.location);
                $('#pac_input').val(place.formatted_address);
            } else {
                window.alert("No results found");
            }


        })
}

$(function() {

    var lat = parseFloat($("#latitude").val());
    var lng = parseFloat($("#longitude").val());

    initMapr(lat, lng);
})