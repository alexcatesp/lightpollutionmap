<?php include "./src/php/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Light Pollution Map </title>
    <link rel="stylesheet" href="./src/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="./src/js/index.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body onload="initialize()">
    <div class='content' id="map"></div>
    <div class='content' id="form">
        <div class="parent d-flex justify-content-md-center align-items-center h-100 bg-dark text-white">
            <div class="child">
                <div class="d-flex flex-row-reverse">
                    <div class="p-2">
                        <button class='btn bg-dark text-white' onclick="hideForm()"><strong>X</strong></button>
                    </div>
                </div>
                <h1>Nuevo marcador</h1>

                <p>
                    Rellena los siguientes campos para agregar un nuevo ejemplo de mala iluminación de nuestras calles.
                </p>

                <form id="markerForm" action="./src/php/sendToDB.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="inputLatitude" name="latitude" placeholder="0.000">
                    <input type="hidden" class="form-control" id="inputLongitude" name="longitude" placeholder="0.000">
                    <div class="form-group">
                        <label for="textarea">Comentarios</label>
                        <textarea class="form-control" id="textDescription" rows="3" name="comments"></textarea>
                        <input type="file" id="file" name="file" accept="image/*" />
                    </div>
                    <button type="submit" value="Enviar" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Creates listener on form submit
        $('#markerForm').on('submit', function(e) {
            e.preventDefault();
            $.post("./src/php/sendToDB.php", {
                lat: document.forms["markerForm"]["latitude"].value,
                lng: document.forms["markerForm"]["longitude"].value,
                desc: document.forms["markerForm"]["comments"].value,
                //img: 
            }, procesar);
        });
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>