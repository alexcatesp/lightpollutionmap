<?php
include_once('./connect.php');

// Process elements
$desc = htmlspecialchars($_POST['desc']);
$lat = floatval(htmlspecialchars($_POST['lat']));
$lng = floatval(htmlspecialchars($_POST['lng']));

// OJO: no sé el nombre hasta que no sepa el id
if (isset($_FILES['image']['name'])) {
    $targetDir = "../../imgs/";
    // LO de abajo es ejemplo
    $name = $_FILES['image']['name'];
    $size = $_FILES['image']['size'];
    $type = $_FILES['image']['type'];
    $temp = $_FILES['image']['tmp_name'];
    $date = date('Y-m-d H:i:s');
   
    move_uploaded_file($temp, $targetDir . $name);
}

// Connect to database
$con = new PDO(DSN, USER, PASSWORD);
$sql = "INSERT INTO `" . DATA_TABLE . "` (`desc`, `lat`, `lon`) VALUES (?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->execute(array($desc, $lat, $lng));
$sql = "SELECT * FROM `".DATA_TABLE. "` ORDER BY `id` DESC LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($result);
