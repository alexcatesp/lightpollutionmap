var marker;
var infoWindow;
var map;

function initialize() {

    // Establish map options
    var mapOptions = {
        zoom: 15,
        center: {
            lat: 41.66396357460837,
            lng: -4.704806504347418
        }
    };
    // Create map on div
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    // Create info window for the future
    infoWindow = new google.maps.InfoWindow();
    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                map.setCenter(pos);
            });
    }

    // Retrieve data from database
    $.post("./src/php/fetchMarkers.php", function (results) {
        if (Object.keys(results).length > 0) {
            // Take the array
            var arrResults = JSON.parse(results);
            // For each position add the marker
            arrResults.forEach(function(element) {
                addMarker(element[0], element[1], element[2]);
            });
        } else {
            console.log("Something went wrong");
        }
    });
    // TODO: retrieve only from current area (pos - margin)


    // Creates listener to click events
    map.addListener("click", (e) => {
        loadHTML(e.latLng);
    });
}

// Proses of making marker 
function addMarker(lat, lng, info) {
    var location = new google.maps.LatLng(lat, lng);
    var marker = new google.maps.Marker({
        map: map,
        position: location
    });
    bindInfoWindow(marker, map, infoWindow, info);
}

// Displays information on markers that are clicked
function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.setContent(html);
        map.panTo(marker.position);
        infoWindow.open(map, marker);
    });
}

$(document).on('submit', '#markerForm', function (e) {
    e.preventDefault();
    var data = document.forms["markerForm"]["comments"].value;
    $.post("./src/php/sendToDB.php", {
        lat: document.forms["markerForm"]["latitude"].value,
        lng: document.forms["markerForm"]["longitude"].value,
        desc: document.forms["markerForm"]["comments"].value
    })
        .done(function (data) {
            if (data != false) {
                // Format the data to be used
                var info = '<p><i>(' + JSON.parse(data).lat + ', ' + JSON.parse(data).lon + ')</i></p><p>' + JSON.parse(data).desc + '</p><p><img src="' + JSON.parse(data).imgpath + '" width="300px"></p>';
                // Add the marker
                addMarker(JSON.parse(data).lat, JSON.parse(data).lon, info);
                // Center marker
                var posdb = new google.maps.LatLng(JSON.parse(data).lat, JSON.parse(data).lon);
                map.panTo(posdb);
                hideForm();
            } else {
                console.log("Something went wrong");
            }
        });
});

function loadHTML(latLng) {
    // Read and load the form in the div
    fetch("./src/html/form.html")
        .then(response => response.text())
        .then(text => document.getElementById("form").innerHTML = text)
        .then(text => document.getElementById("inputLatitude").value = '' + latLng.toJSON().lat)
        .then(text => document.getElementById("inputLongitude").value = '' + latLng.toJSON().lng)

    // Make it visible over the map
    document.getElementById("form").style.zIndex = 1;
    document.getElementById("map").style.zIndex = -1;
}

function hideForm() {
    // Hide the form below the map
    document.getElementById("form").style.zIndex = -1;
    document.getElementById("map").style.zIndex = 1;
}