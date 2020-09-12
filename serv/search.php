<?php
session_start();
include("conn.php");

// Init values
$_SESSION['searchArgument'] = $_POST['inputAuthor'];
$author = $_POST['inputAuthor'];
$resultTable = "";

// Query
$searchResult = $conn->query("SELECT * FROM models WHERE author = '$author'")->fetchAll();

// Get values
if (!empty($searchResult)) {
    foreach ($searchResult as $row) {
        $date = date("m/d/Y", strtotime($row['date']));
        $resultTable .= "<tr><td>".$row['idmodel']."</td><td>".$row['author']."</td><td>".$row['description']."</td><td>".$date."</td></tr>";
    }
} else {
    $resultTable = "<tr><td colspan='4'>Nothing has been found.</td></tr>";
}

// End
$_SESSION['searchResult'] = $resultTable;
$_SESSION['searchView'] = "d-block";
header("Location: ../index.php#search");

?>