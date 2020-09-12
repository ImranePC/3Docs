<?php
session_start();
include('conn.php');

// Get POST values
$author = $_POST['inputName'];
$description = $_POST['inputDesc'];
$fileName = $_FILES['inputFile']['name'];
//$file = file_get_contents($_FILES['inputFile']['tmp_name']);

$alertMsg = "";

//// Verify POST values
$error = false;

// 1 - file extension
if (strpos($fileName, '.gltf') !== false OR strpos($fileName, '.glb') !== false){
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

    // if error, go back
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
    $idModel = substr("ID".str_shuffle(uniqid()), 0, 9);
    $query->execute(array($idModel));
    $result = $query->fetchColumn();
}

// Upload to server
$savePath = "/wamp64/www/3Docs/model/";
$savedFileName = $idModel;

if (move_uploaded_file($_FILES['inputFile']['tmp_name'], $savePath . $savedFileName)) {
    // It work
} else {
    $alertMsg = "We are encountering a server problem, please try again later.";
    $_SESSION['alertMsg'] = $alertMsg;
    $_SESSION['alertColor'] = "danger";
    header("Location: ../index.php");
};

// Insert
$sql = "INSERT into models (idmodel, author, description, filename) VALUES (:idmodel,:author,:description, :filename)";
$query = $conn->prepare($sql);
$query->execute(array(
    'idmodel' => $idModel,
    'author' => $author,
    'description' => $description,
    'filename' => $fileName
));

$_SESSION['alertMsg'] = "Votre modèle à bien été mis en ligne, voici son ID : $idModel";
$_SESSION['alertColor'] = "success";

}

// set Alert
$_SESSION['msgFlash'] = true;

header("Location: ../index.php");

?>