
var map;

function initialize() {

    // Establish map options (location and zoom)
    var latitude = 41.66396357460837;
    var longitude = -4.704806504347418;
    var zoom = 13;

    // Create map on div id='map'
    map = createMap('map', latitude, longitude, zoom);

    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                map.setView([position.coords.latitude, position.coords.longitude], zoom);
            });
    }

    // Create tile layer
    createTileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', 19, '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>', map);

    // Retrieve data from database
    $.post("./src/php/fetchMarkers.php", function (results) {
        if (Object.keys(results).length > 0) {
            // Take the array
            var arrResults = JSON.parse(results);
            // For each position add the marker
            arrResults.forEach(function (element) {
                var marker = addMarker(element[0], element[1], map).bindPopup(element[2]);
                marker.on('click', onMarkerClick);
            });
        } else {
            console.log("Something went wrong");
        }
    });
    // TODO: retrieve only from current area (pos - margin)

    // Creates listener to click events anywhere on the map
    map.on('click', onMapClick);

    // I hide the form to make the map visible
    hideForm();
}

// Function for creating a map
function createMap(where, latitude, longitude, zoom) {
    return L.map(where).setView([latitude, longitude], zoom);
}

// Function for creating a tile layer on top of a map
function createTileLayer(url, maxZoom, attribution, map) {
    L.tileLayer(url, { 'maxZoom': maxZoom, 'attribution': attribution }).addTo(map);
}

// Function to create a marker 
function addMarker(latitude, longitude, map) {
    return L.marker([latitude, longitude]).addTo(map);
}

// Function for responding to click events on map
function onMapClick(e) {
    // Make it visible over the map
    document.getElementById("inputLatitude").value = '' + e.latlng.lat;
    document.getElementById("inputLongitude").value = '' + e.latlng.lng;
    document.getElementById("form").style.zIndex = 1;
    document.getElementById("map").style.zIndex = -1;
}

function onMarkerClick() {
    this.openPopup();
    //map.panTo(this.getLatLng());
}

function procesar(results) {
    if (Object.keys(results).length > 0) {
        // Take the array
        var arrResults = JSON.parse(results);
        // Format the data to be used
        var info = '<p><i>(' + arrResults['lat'] + ', ' + arrResults['lon'] + ')</i></p><p>' + arrResults['desc'] + '</p><p><img src="' + arrResults['imgpath'] + '" width="300px"></p>';
        // Add the marker
        var marker = addMarker(arrResults['lat'], arrResults['lon'], map).bindPopup(info);
        // Create event listener for clicks onto markers
        marker.on('click', onMarkerClick);
        // Hide the form
        hideForm();
    }
}

function hideForm() {
    // Hide the form below the map
    document.getElementById("form").style.zIndex = -1;
    document.getElementById("map").style.zIndex = 1;
}