<?php include "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Marker Map </title>
    <link rel="stylesheet" href="./style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsneVM_MSta--x2Sc-j1A55ZJDKPOAFVg&v=weekly" defer></script>
    <script>
        var marker;

        function initialize() {
            var infoWindow = new google.maps.InfoWindow;

            var mapOptions = {
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);
            var bounds = new google.maps.LatLngBounds();

            // Retrieve data from database
            // TODO: retrieve only from current area
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
                placeMarkerAndPanTo(e.latLng, map);
            });

            // Proses of making marker 
            function addMarker(lat, lng, info) {
                var lokasi = new google.maps.LatLng(lat, lng);
                bounds.extend(lokasi);
                var marker = new google.maps.Marker({
                    map: map,
                    position: lokasi
                });
                map.fitBounds(bounds);
                bindInfoWindow(marker, map, infoWindow, info);
            }

            // Displays information on markers that are clicked
            function bindInfoWindow(marker, map, infoWindow, html) {
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(map, marker);
                });
            }

            // Makes it possible to add new markers
            function placeMarkerAndPanTo(latLng, map) {
                // Create a marker with chosen geolocation
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                });
                // Center marker
                map.panTo(latLng);

                // Load form.html on div
                loadHTML();

                /*

                // Store content to show in variable
                var html = JSON.stringify(latLng.toJSON(), null, 2);
                // TODO: popup to register info and send to db
                // It has to be sent asynchronously to a php function via post (jquery)
                $.post("sendToDB.php", {
                        lat: JSON.parse(html).lat,
                        lng: JSON.parse(html).lng
                    })
                    .done(function(data) {
                        console.log(data);
                        // Call function to create click event on this marker too
                        var html2 = '<h1>' + JSON.parse(data).desc + '</h1><p><i>(' + JSON.parse(data).lat + ', ' + JSON.parse(data).lon + ')</i></p><p><img src="' + JSON.parse(data).imgpath + '" width="300px"></p>';
                        bindInfoWindow(marker, map, infoWindow, html2);
                        infoWindow.setContent(html2);
                        infoWindow.open(map, marker);
                    });
*/
            }

        }

        function loadHTML() {
            fetch("form.html")
                .then(response => response.text())
                .then(text => document.getElementById("form").innerHTML = text);

            document.getElementById("form").style.zIndex = 1;
            document.getElementById("map").style.zIndex = -1;
        }

        function hideForm() {
            document.getElementById("form").style.zIndex = -1;
            document.getElementById("map").style.zIndex = 1;
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

</head>

<body onload="initialize()">
    <div class='content' id="map"></div>
    <div class='content' id="form" onclick="hideForm()"></div>
</body>

</html>