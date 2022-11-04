<?php include "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Light Pollution Map </title>
    <link rel="stylesheet" href="./style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsneVM_MSta--x2Sc-j1A55ZJDKPOAFVg&v=weekly" defer></script>

    <!-- Geolocation -->
    <script>
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
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP
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
            // TODO: retrieve only from current area (pos - margin)
            <?php
            $con = mysqli_connect(HOST, USER, PASSWORD, DB);
            $query = mysqli_query($con, "select * from " . DATA_TABLE);
            while ($data = mysqli_fetch_array($query)) {
                // Recupera la info de los marcadores
                $id = $data['id'];
                $desc = $data['desc'];
                $lat = $data['lat'];
                $lon = $data['lon'];
                $img = $data['imgpath'];

                // Posiciona los marcadores en el mapa
                echo ("addMarker($lat, $lon, '<h1>$desc</h1><p><i>($lat, $lon)</i></p><p><img src=\"$img\" width=\"300px\"></p>');\n");
            }
            mysqli_close($con);
            ?>

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
            google.maps.event.addListener(marker, 'click', function() {
                infoWindow.setContent(html);
                map.panTo(marker.position);
                infoWindow.open(map, marker);
            });
        }

        $(document).on('submit', '#markerForm', function(e) {
            e.preventDefault();
            var data = document.forms["markerForm"]["comments"].value;
            $.post("sendToDB.php", {
                    lat: document.forms["markerForm"]["latitude"].value,
                    lng: document.forms["markerForm"]["longitude"].value,
                    desc: document.forms["markerForm"]["comments"].value
                })
                .done(function(data) {
                    if (data != false) {
                        // Format the data to be used
                        var info = '<h1>' + JSON.parse(data).desc + '</h1><p><i>(' + JSON.parse(data).lat + ', ' + JSON.parse(data).lon + ')</i></p><p><img src="' + JSON.parse(data).imgpath + '" width="300px"></p>';
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
            fetch("form.html")
                .then(response => response.text())
                .then(text => document.getElementById("form").innerHTML = text)
                .then(text => document.getElementById("inputLatitude").value = '' + latLng.toJSON().lat)
                .then(text => document.getElementById("inputLongitude").value = '' + latLng.toJSON().lng);
            
                // Make it visible over the map
            document.getElementById("form").style.zIndex = 1;
            document.getElementById("map").style.zIndex = -1;
        }

        function hideForm() {
            // Hide the form below the map
            document.getElementById("form").style.zIndex = -1;
            document.getElementById("map").style.zIndex = 1;
        }

        //google.maps.event.addDomListener(window, 'load', initialize);
    </script>

</head>

<body onload="initialize()">
    <div class='content' id="map"></div>
    <div class='content' id="form"></div>
</body>

</html>