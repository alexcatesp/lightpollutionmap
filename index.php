<?php include "./src/php/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Light Pollution Map </title>
    <link rel="stylesheet" href="./src/css/style.css">
    <script src="./src/js/index.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsneVM_MSta--x2Sc-j1A55ZJDKPOAFVg&v=weekly" defer></script>
</head>

<body onload="initialize()">
    <div class='content' id="map"></div>
    <div class='content' id="form"></div>
</body>

</html>