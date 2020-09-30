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
        $date = date("m/d/y", strtotime($row['date']));
        $id = "row".$row['id'];
        $idmodel = $row['idmodel'];
        $description = $row['description'];
        if (strlen($description) > 10) $description = substr($description, 0, 9) . "...";

        $resultTable .= 
        "<tr><td style='width: 50px'><button type='button' onclick=\"copy('$id')\" class='btn btn-outline-dark btn-sm' data-toggle='popover' data-placement='left' data-content='Copied !'>Copy ID</button>"
        ."</td><td style='width: 150px'><textarea id='$id' rows='1'>$idmodel</textarea></td><td>".$description."</td><td>".$date."</td></tr>";
    }
} else {
    $resultTable = "<tr><td colspan='4'>Nothing has been found.</td></tr>";
}

// End
$_SESSION['searchResult'] = $resultTable;
$_SESSION['searchView'] = "d-block";
header("Location: ../research");

?>