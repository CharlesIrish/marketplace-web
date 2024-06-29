<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    
    // Manejo de la foto de perfil
    $photo = '';
    if ($_FILES['photo']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $photo = $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    }

    $sql = "UPDATE users SET name = '$name', photo = '$photo' WHERE id = $user_id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Datos guardados correctamente.';
    } else {
        $_SESSION['message'] = 'Error al guardar los datos: ' . mysqli_error($conn);
    }

    header('Location: configuracion.php');
    exit;
}

?>
