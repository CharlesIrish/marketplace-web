<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        header('Location: my_products.php');
        exit;
    } else {
        echo "Error al eliminar el producto: " . mysqli_error($conn);
    }
}
?>

