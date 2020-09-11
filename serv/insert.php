<?php
session_start();
include('conn.php');
// Get POST values
//$_POST[''];

$author = $_POST['inputName'];
$description = $_POST['inputDesc'];
$file = $_POST['inputFile'];

//// Verify POST values

$error = false;

// 1 - file extension
if (strpos($file, '.gltf') !== false OR strpos($file, '.glb') !== false){
    // No error, continue
} else {
    // Wrong file extension
    $error = true;
}

// 2 - string size
if (strlen($description) > 24 OR strlen($author) > 24) {
    $error = true;
}


echo "$author - $description - $file";

if ($error == true) {
    
    header("Location: ../index.php");

} else {

// Generate unique idModel
$result = 1;
$sql = "SELECT COUNT(idmodel) FROM models WHERE idmodel = ?";
$query = $conn->prepare($sql);

while ($result != 0) {
    $idModel = substr("#ID".str_shuffle(uniqid()), 0, 9);
    $query->execute(array($idModel));
    $result = $query->fetchColumn();
}

// Insert
$sql = "INSERT into models (idmodel, author, description, file) VALUES (:idmodel,:author,:description,:file)";
$query = $conn->prepare($sql);
$query->execute(array(
    'idmodel' => $idModel,
    'author' => $author,
    'description' => $description,
    'file' => $file
));

}

// set Alert
$_SESSION['msgFlash'] = true;
$_SESSION['idModel'] = $idModel;
header("Location: ../index.php");

?>