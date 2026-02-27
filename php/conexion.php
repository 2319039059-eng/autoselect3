<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "autoselect1";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Charset recomendado
$conn->set_charset("utf8mb4");
?>
