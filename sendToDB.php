<?php
include_once('./connect.php');
$desc = htmlspecialchars($_POST['desc']);
$lat = floatval(htmlspecialchars($_POST['lat']));
$lng = floatval(htmlspecialchars($_POST['lng']));
$con = new PDO(DSN, USER, PASSWORD);
$sql = "INSERT INTO `" . DATA_TABLE . "` (`desc`, `lat`, `lon`) VALUES (?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->execute(array($desc, $lat, $lng));
$sql = "SELECT * FROM `".DATA_TABLE. "` ORDER BY `id` DESC LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($result);
