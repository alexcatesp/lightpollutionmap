<?php

echo json_encode(array("saludo" => "Hola, Pepe"));

// Include connection constants
//include_once('../../connect.php');

/*if(isset($_POST['latitude']) || isset($_POST['longitude']) || isset())

$desc = htmlspecialchars($_POST['desc']);
$lat = floatval(htmlspecialchars($_POST['lat']));
$lng = floatval(htmlspecialchars($_POST['lng']));
$img = $_POST['img'];

// OJO: no sé el nombre hasta que no sepa el id
if (isset($_FILES['image'])) {

    $targetDir = "./imgs/";
    // LO de abajo es ejemplo
    $name = $_FILES['image']['name'];
    $type = $_FILES['image']['type'];
    $size = $_FILES['image']['size'];
    $temp = $_FILES['image']['tmp_name'];
    $date = date('Y-m-d H:i:s');
    $targetFile = $targetDir . basename($name);
   
    move_uploaded_file($temp, $targetFile);
}

// Connect to database
$con = new PDO(DSN, USER, PASSWORD);
$sql = "INSERT INTO `" . DATA_TABLE . "` (`desc`, `lat`, `lon`, `imgpath`) VALUES (?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->execute(array($desc, $lat, $lng, $targetFile));
$sql = "SELECT * FROM `".DATA_TABLE. "` ORDER BY `id` DESC LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($result);*/

/*// Recover info from form
$desc = htmlspecialchars($_POST['comments']);
$lat = floatval(htmlspecialchars($_POST['latitude']));
$lng = floatval(htmlspecialchars($_POST['longitude']));

// Recover image (if it has been uploaded)
if (isset($_FILES['image'])) {
    // Define the definitive path for the images
    $targetDir = "./imgs/";
    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be less than 2 MB';
    }

    if (empty($errors) == true) {
        // Move image to definitive path
        move_uploaded_file($file_tmp, $targetDir . $file_name);
        // Connect to database
        $con = new PDO(DSN, USER, PASSWORD);
        $sql = "INSERT INTO `" . DATA_TABLE . "` (`desc`, `lat`, `lon`, `imgpath`) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->execute(array($desc, $lat, $lng, $targetFile));
        $sql = "SELECT * FROM `" . DATA_TABLE . "` ORDER BY `id` DESC LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $returnCode = <<<CODE
        <script>
        console.log({$result});
        // Format the data to be used
        var info = '<p><i>(' + {$result['lat']} + ', ' + {$result['lon']} + ')</i></p><p>' + {$result['desc']} + '</p><p><img src="' + {$result['imgpath']} + '" width="300px"></p>';
        // Add the marker
        var marker = addMarker({$result['lat']}, {$result['lon']}, map).bindPopup(info);
        // Create event listener for clicks onto markers
        marker.on('click', onMarkerClick);                
        // Hide the form
        hideForm();
        </script>
        CODE;
    } else {
        print_r($errors);
    }
}*/
