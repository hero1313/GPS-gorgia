var addLocMap, addLocMarker, infowindow, geocoder;

function initMapr() {
    addLocMap = new google.maps.Map(document.getElementById('add_map'), {
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
    autocomplete.bindTo('bounds', addLocMap);

    addLocMarker = new google.maps.Marker({
        map: addLocMap
    });

   
    addLocMarker.setVisible(true);

    addLocMap.addListener('click', function(e) {

        var lat = e.latLng.lat();
        var lng = e.latLng.lng();
        addLocMap.panTo(new google.maps.LatLng(lat, lng));
        setPlaceOnaddLocMap(lat, lng);
    });

}


function setPlaceOnaddLocMap(lat, lng) {

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
                    addLocMap.fitBounds(place.geometry.viewport);
                } else {
                    addLocMap.setCenter(place.geometry.location);
                    addLocMap.setZoom(12);
                }
                addLocMarker.setPosition(place.geometry.location);
                $('#pac_input').val(place.formatted_address);

            } else {
                window.alert("No results found");
            }


        })
}

$(function() {

    initMapr();
})