<?php
include 'connects.php';

$id = $_GET['id'];

$sql = "DELETE FROM vijesti WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Vijest je uspješno izbrisana.";
} else {
    echo "Greška: " . $conn->error;
}

$conn->close();
?>
