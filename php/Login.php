<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (empty($usuario) || empty($password)) {
        echo "<script>alert('Todos los campos son obligatorios.');
              window.history.back();</script>";
        exit;
    }

    // Buscar al usuario por correo
    $sql = $conn->prepare("
        SELECT Id_cliente, Nombre_C, Contrasena_C
        FROM Clientes
        WHERE Correo_C = ?
        LIMIT 1
    ");

    if (!$sql) {
        die("Error en prepare(): " . $conn->error);
    }

    $sql->bind_param("s", $usuario);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();

        if (password_verify($password, $row['Contrasena_C'])) {

            session_start();
            $_SESSION['Id_cliente'] = $row['Id_cliente'];
            $_SESSION['Nombre_C'] = $row['Nombre_C'];

            echo "<script>
                    alert('Inicio de sesión exitoso');
                    window.location='../Interfaces/Catalogo.html';
                  </script>";

        } else {
            echo "<script>alert('Contraseña incorrecta.');
                  window.history.back();</script>";
        }
    } else {
        echo "<script>alert('El usuario no existe.');
              window.history.back();</script>";
    }

    $sql->close();
}

$conn->close();
?>
