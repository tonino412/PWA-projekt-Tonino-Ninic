<?php
include 'connect.php';

$sql_vijesti = "CREATE TABLE IF NOT EXISTS vijesti (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30) NOT NULL,
    about VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    archive BOOLEAN NOT NULL,
    photo VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_vijesti) === TRUE) {
    echo "Table vijesti created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql_korisnik = "CREATE TABLE IF NOT EXISTS korisnik (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    admin BOOLEAN NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_korisnik) === TRUE) {
    echo "Table korisnik created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
