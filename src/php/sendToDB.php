<?php

// Include connection constants
include_once('./connect.php');

if (isset($_POST['latitude']) || isset($_POST['longitude']) || isset($_POST['comments'])) {

    $desc = htmlspecialchars($_POST['comments']);
    $lat = floatval(htmlspecialchars($_POST['latitude']));
    $lng = floatval(htmlspecialchars($_POST['longitude']));

    if (isset($_FILES['image'])) {

        $targetDir = "../../imgs/";
        // LO de abajo es ejemplo
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $size = $_FILES['image']['size'];
        $temp = $_FILES['image']['tmp_name'];
        $date = date('Y-m-d H:i:s');
        $targetFile = $targetDir . basename($name) . "_" . $date;

        move_uploaded_file($temp, $targetFile);
    } else {
        $targetFile = null;
    }

    // Connect to database
    $con = new PDO(DSN, USER, PASSWORD);
    $sql = "INSERT INTO `" . DATA_TABLE . "` (`desc`, `lat`, `lon`, `imgpath`) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    //$stmt->execute(array($desc, $lat, $lng, $targetFile));
    $stmt->execute(array($desc, $lat, $lng, $targetFile));
    $sql = "SELECT * FROM `" . DATA_TABLE . "` ORDER BY `id` DESC LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(array('lat' => $result['lat'], 'lon' => $result['lon'], 'desc' => $result['desc'], 'imgpath' => $result['imgpath']));
}