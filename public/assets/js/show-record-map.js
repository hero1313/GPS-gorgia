// $(".edit_maps").click(function(){
//     var Id = $(this).attr('id');
    
//     var lats = $(this).data('lat');
//     var lngs = $(this).data('lng');

//     var map, marker, infowindow, geocoder;
//     function initMap(lat, lng) {
//     map = new google.maps.Map(document.getElementById(Id + "_s"), {
//         center: {
//             lat: 42.053372,
//             lng: 44.170532
//         },
//         zoom: 7
//     });
//     geocoder = new google.maps.Geocoder();
//     marker = new google.maps.Marker({
//         map: map
//     });

//     marker.setVisible(true);
//     map.panTo(new google.maps.LatLng(lats, lngs));
//     setPlaceOnMap(lats, lngs);

//     map.addListener('click', function(e) {
//         var lat = e.latLng.lat();
//         var lng = e.latLng.lng();
//         map.panTo(new google.maps.LatLng(lat, lng));
//         setPlaceOnMap(lat, lng);
//     });
// }

// function handleLocationError(browserHasGeolocation, infoWindow, pos) {
//     infoWindow.setPosition(pos);
//     infoWindow.setContent(
//         browserHasGeolocation ?
//         "Error: The Geolocation service failed." :
//         "Error: Your browser doesn't support geolocation."
//     );
//     infoWindow.open(map);
// }

// function setPlaceOnMap(lat, lng) {

//     $('#'+ Id + '_lat').val(lat);
//     $('#'+ Id + '_lng').val(lng);

//     geocoder
//         .geocode({
//             location: {
//                 lat: lat,
//                 lng: lng
//             }
//         })
//         .then((response) => {
//             if (response.results[1]) {
//                 var place = response.results[1];
//                 if (place.geometry.viewport) {
//                     map.fitBounds(place.geometry.viewport);
//                 } else {
//                     map.setCenter(place.geometry.location);
//                     map.setZoom(12);
//                 }
//                 marker.setPosition(place.geometry.location);
//                 $('#pac_input').val(place.formatted_address);
//                 if (place.address_components) {
//                     var short_names = [];
//                     var long_names = [];
//                     for (var i = 0; i < place.address_components.length; i++) {
//                         short_names.push(place.address_components[i].short_name);
//                         long_names.push(place.address_components[i].long_name);
//                         if (place.address_components[i].types[0] == 'locality') {
//                             $("#city").val(place.address_components[i].long_name);
//                         }
//                         if (place.address_components[i].types[0] == 'country') {
//                             $("#country").val(place.address_components[i].long_name);
//                         }
//                     }

//                     var detailed_info = "<p><strong>მისამართი: </strong>" + long_names.join(", ") + "<p>";
//                     detailed_info += "<p><strong>გრძედი: </strong>" + place.geometry.location.lat() + "<p>";
//                     detailed_info += "<p><strong>განედი: </strong>" + place.geometry.location.lng() + "<p>";
//                     $("#map_address").val(long_names.join(", "));
//                 }
//             } else {
//                 window.alert("No results found");
//             }


//         })
// }

// $(function() {

//     var lat = parseFloat($("#latitude").val());
//     var lng = parseFloat($("#longitude").val());

//     initMap(lat, lng);
// })
// });

var map, marker, infowindow, geocoder;

// დისტანციის დათვლის ფუნქცია
function calculateDistance(lat1, lon1, lat2, lon2) {
    var radius = 6371000; // Earth radius in meters

    var lat1Rad = lat1 * Math.PI / 180;
    var lon1Rad = lon1 * Math.PI / 180;
    var lat2Rad = lat2 * Math.PI / 180;
    var lon2Rad = lon2 * Math.PI / 180;

    var deltaLat = lat2Rad - lat1Rad;
    var deltaLon = lon2Rad - lon1Rad;

    var a = Math.sin(deltaLat / 2) * Math.sin(deltaLat / 2) +
            Math.cos(lat1Rad) * Math.cos(lat2Rad) *
            Math.sin(deltaLon / 2) * Math.sin(deltaLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    var distance = radius * c;

    return distance;
}

// ლოკაციის განახლების ფუნქცია
function curentLocation() {
    map = new google.maps.Map(document.getElementById('map_custom'));
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                $('#curent_lat').val(pos.lat);
                $('#curent_lng').val(pos.lng);
                $('.check-in').each(function() {
                    var locationLat = parseFloat($(this).data('lat'));
                    var locationLon = parseFloat($(this).data('lng'));
                    var radius = parseFloat($(this).data('radius'));
                    var distance = calculateDistance(pos.lat, pos.lng, locationLat, locationLon);

                    if (distance <= radius) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('.check-out').each(function() {
                    var locationLat = parseFloat($(this).data('lat'));
                    var locationLon = parseFloat($(this).data('lng'));
                    var radius = parseFloat($(this).data('radius'));
                
                    var distance = calculateDistance(pos.lat, pos.lng, locationLat, locationLon);
                
                    if (distance <= radius) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        );
    }
    geocoder = new google.maps.Geocoder();
}

// ლოკაციის განახლება
$(function () {
    curentLocation();
    setInterval(curentLocation, 10000); // Run decrementCountdown() every second
    $(document).on('keyup keypress keydown', '#pac-input', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

})

// ტაიმერი
$(document).ready(function() {
        var count = 10;
        var countdownDisplay = $("#countdown-display");

        var countdownInterval = setInterval(function() {
            count--;
            countdownDisplay.text(count);

            if (count <= 0) {
                count = 10
            }
        }, 1000);
});

// თუ ჩექინის შემდეგ არ გასულა შესაბამისი დრო
document.addEventListener('DOMContentLoaded', function() {
    var checkoutButtons = document.querySelectorAll('.check-out');
    checkoutButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            var currentTime = new Date();
            var checkoutTime = new Date(this.dataset.time);
            var hours = checkoutTime.getHours();
            var minutes = checkoutTime.getMinutes();
            var seconds = checkoutTime.getSeconds();

            var formattedTime = hours + ':' + minutes + ':' + seconds;
            if (checkoutTime > currentTime) {
                Swal.fire({
                title: 'ჩექაუთი ვერ შედგა',
                text: 'ჩექაუთი განხორციელება შეგეძლებათ ' + formattedTime + ' დროის შემდეგ',
                icon: 'error',
                confirmButtonText: 'დახურვა'
                })
                $(this).removeAttr('data-toggle');
            }
            else{
                $(this).attr('data-toggle', 'modal');
            }
        });
    });
});