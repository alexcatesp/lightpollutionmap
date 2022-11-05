<?php
include_once('connect.php');

$con = mysqli_connect(HOST, USER, PASSWORD, DB);
$query = mysqli_query($con, "select * from " . DATA_TABLE);
$results = array();
while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    // Recupera la info de los marcadores
    $id = $data['id'];
    $desc = $data['desc'];
    $lat = $data['lat'];
    $lon = $data['lon'];
    $img = $data['imgpath'];

    $results[] = array($lat, $lon, "<p><i>($lat, $lon)</i></p><p>$desc</p><p><img src=\"$img\" width=\"300px\"></p>");
}
mysqli_close($con);
echo json_encode($results);

