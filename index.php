<?php include "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Marker Map </title>
    <link rel="stylesheet" href="./style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsneVM_MSta--x2Sc-j1A55ZJDKPOAFVg&callback=initMap&v=weekly" defer></script>
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
            <?php
            $query = mysqli_query($con, "select * from data_location");
            while ($data = mysqli_fetch_array($query)) {
                $nama = $data['desc'];
                $lat = $data['lat'];
                $lon = $data['lon'];

                echo ("addMarker($lat, $lon, '<b>$nama</b>');\n");
            }
            ?>

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

        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

</head>

<body onload="initialize()">
    <div id="map"></div>
</body>

</html>