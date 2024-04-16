$(".edit_maps").click(function(){
    var Id = $(this).attr('id');
    
    var lats = $(this).data('lat');
    var lngs = $(this).data('lng');

    var map, marker, infowindow, geocoder;

function initMap(lat, lng) {
    map = new google.maps.Map(document.getElementById(Id + "_s"), {
        center: {
            lat: 42.053372,
            lng: 44.170532
        },
        zoom: 7
    });

    infoWindow = new google.maps.InfoWindow();
    const locationButton = document.getElementById('custom_btn');
    locationButton.addEventListener("click", () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    map.setCenter(pos);
                    console.log(pos.lat)
                    map.panTo(new google.maps.LatLng(pos.lat, pos.lng));
                    setPlaceOnMap(pos.lat, pos.lng);
                },
                () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                }
            );
        } else {
            handleLocationError(false, infoWindow, map.getCenter());
        }
    });

    geocoder = new google.maps.Geocoder();
    marker = new google.maps.Marker({
        map: map
    });

    marker.setVisible(true);
    map.panTo(new google.maps.LatLng(lats, lngs));
    setPlaceOnMap(lats, lngs);

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

    $('#'+ Id + '_lat').val(lat);
    $('#'+ Id + '_lng').val(lng);

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
                if (place.address_components) {
                    var short_names = [];
                    var long_names = [];
                    for (var i = 0; i < place.address_components.length; i++) {
                        short_names.push(place.address_components[i].short_name);
                        long_names.push(place.address_components[i].long_name);
                        if (place.address_components[i].types[0] == 'locality') {
                            $("#city").val(place.address_components[i].long_name);
                        }
                        if (place.address_components[i].types[0] == 'country') {
                            $("#country").val(place.address_components[i].long_name);
                        }
                    }

                    var detailed_info = "<p><strong>მისამართი: </strong>" + long_names.join(", ") + "<p>";
                    detailed_info += "<p><strong>გრძედი: </strong>" + place.geometry.location.lat() + "<p>";
                    detailed_info += "<p><strong>განედი: </strong>" + place.geometry.location.lng() + "<p>";
                    $("#map_address").val(long_names.join(", "));
                }
            } else {
                window.alert("No results found");
            }


        })
}

$(function() {

    var lat = parseFloat($("#latitude").val());
    var lng = parseFloat($("#longitude").val());

    initMap(lat, lng);
})
});