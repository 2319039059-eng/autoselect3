<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar campos vacíos
    if (
        empty($_POST['Nombre_C']) ||
        empty($_POST['A_paterno_C']) ||
        empty($_POST['A_materno_C']) ||
        empty($_POST['Correo_C']) ||
        empty($_POST['Contrasena_C'])
    ) {
        echo "<script>alert('Todos los campos son obligatorios.');
              window.history.back();
              </script>";
        exit;
    }

    $Nombre_C     = trim($_POST['Nombre_C']);
    $A_paterno_C  = trim($_POST['A_paterno_C']);
    $A_materno_C  = trim($_POST['A_materno_C']);
    $Correo_C     = trim($_POST['Correo_C']);
    $Contrasena_C = password_hash($_POST['Contrasena_C'], PASSWORD_DEFAULT);

    $id_tipo_usuario = 2;

    // *** CONSULTA SIN SALTOS AL INICIO ***
    $sql = $conn->prepare("INSERT INTO Clientes 
        (Id_tipo_usuario, Nombre_C, A_paterno_C, A_materno_C, Contrasena_C, Correo_C)
        VALUES (?, ?, ?, ?, ?, ?)");

    if (!$sql) {
        die("Error en prepare(): " . $conn->error);
    }

    $sql->bind_param("isssss",
        $id_tipo_usuario,
        $Nombre_C,
        $A_paterno_C,
        $A_materno_C,
        $Contrasena_C,
        $Correo_C
    );

    if ($sql->execute()) {
        echo "<script>
                alert('Cuenta creada exitosamente');
                window.location='../Interfaces/Login.html';
              </script>";
    } else {
        echo "Error al registrar: " . $sql->error;
    }

    $sql->close();
}

$conn->close();
?>
