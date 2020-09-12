<?php
session_start();
include('conn.php');

// Get POST values
$author = $_POST['inputName'];
$description = $_POST['inputDesc'];
$file = $_POST['inputFile'];
$alertMsg = "";

//// Verify POST values
$error = false;

// 1 - file extension
if (strpos($file, '.gltf') !== false OR strpos($file, '.glb') !== false){
    // No error, continue
} else {
    // Wrong file extension
    $error = true;
    $alertMsg .= "Wrong file format";
}

// 2 - string size
if (strlen($description) > 24 OR strlen($author) > 24) {
    $error = true;
    if ($alertMsg != "") {
        $alertMsg .= " - ";
    }
    $alertMsg .= "Name or description too long, 24 characters max";
}


echo "$author - $description - $file";

if ($error == true) {

    $_SESSION['alertMsg'] = $alertMsg;
    $_SESSION['alertColor'] = "danger";
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

$_SESSION['alertMsg'] = "Votre modèle à bien été mis en ligne, voici son ID : $idModel";
$_SESSION['alertColor'] = "success";

}

// set Alert
$_SESSION['msgFlash'] = true;

header("Location: ../index.php");

?>