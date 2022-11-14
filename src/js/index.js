function initialize() {

    // Establish map options (location and zoom)
    var latitude = 41.66396357460837;
    var longitude = -4.704806504347418;
    var zoom = 13;
    var map;

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
    // Read and load the form in the div
    fetch("./src/html/form.html")
        .then(response => response.text())
        .then(text => document.getElementById("form").innerHTML = text)
        .then(text => document.getElementById("inputLatitude").value = '' + e.latlng.lat)
        .then(text => document.getElementById("inputLongitude").value = '' + e.latlng.lng)

    // Make it visible over the map
    document.getElementById("form").style.zIndex = 1;
    document.getElementById("map").style.zIndex = -1;
}

function onMarkerClick() {
    this.openPopup();
}

$('#markerForm').on('submit', function(e) {
    console.log("Estoy en el JS");
    e.preventDefault();
    $.post("./src/php/sendToDB.php", {
        lat: document.forms["markerForm"]["latitude"].value,
        lng: document.forms["markerForm"]["longitude"].value,
        desc: document.forms["markerForm"]["comments"].value
    }, procesar)
});

function procesar(data) {
    console.log(data);
}


/*if (data != false) {
    // Format the data to be used
    var info = '<p><i>(' + JSON.parse(data).lat + ', ' + JSON.parse(data).lon + ')</i></p><p>' + JSON.parse(data).desc + '</p><p><img src="' + JSON.parse(data).imgpath + '" width="300px"></p>';
    // Add the marker
    var marker = addMarker(JSON.parse(data).lat, JSON.parse(data).lon, map).bindPopup(info);
    // Create event listener for clicks onto markers
    marker.on('click', onMarkerClick);                
    // Hide the form
    hideForm();
} else {
    console.log("Something went wrong");
}*/
/*$(document).on('submit', '#markerForm', function (e) {
    e.preventDefault();
    const fd = new FormData();
    fd.append("file", document.forms["markerForm"]["image"].files[0]);
    console.log(fd);
    $.post("./src/php/sendToDB.php", {
        lat: document.forms["markerForm"]["latitude"].value,
        lng: document.forms["markerForm"]["longitude"].value,
        desc: document.forms["markerForm"]["comments"].value,
        //img: document.forms["markerForm"]["image"].files[0]
        img: fd
    })
        .done(function (data) {
            if (data != false) {
                // Format the data to be used
                var info = '<p><i>(' + JSON.parse(data).lat + ', ' + JSON.parse(data).lon + ')</i></p><p>' + JSON.parse(data).desc + '</p><p><img src="' + JSON.parse(data).imgpath + '" width="300px"></p>';
                // Add the marker
                var marker = addMarker(JSON.parse(data).lat, JSON.parse(data).lon, map).bindPopup(info);
                // Create event listener for clicks onto markers
                marker.on('click', onMarkerClick);                
                // Hide the form
                hideForm();
            } else {
                console.log("Something went wrong");
            }
        });
});*/

function hideForm() {
    // Hide the form below the map
    document.getElementById("form").style.zIndex = -1;
    document.getElementById("map").style.zIndex = 1;
}