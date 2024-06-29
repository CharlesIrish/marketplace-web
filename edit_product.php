<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Verifica si el producto pertenece al usuario que inició sesión
    $sql = "SELECT * FROM products WHERE id = $product_id AND user_id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar CSRF
            // ...

            // Obtén los nuevos datos del formulario (solo nombre y precio)
            $new_name = $_POST['name'];
            $new_price = $_POST['price'];

            // Actualiza la base de datos (solo nombre y precio)
            $sql = "UPDATE products SET name = '$new_name', price = '$new_price' WHERE id = $product_id";
            if (mysqli_query($conn, $sql)) {
                header('Location: my_products.php'); // Redirigir a la página de productos
                exit;
            } else {
                echo "Error al actualizar el producto: " . mysqli_error($conn);
            }
        }
    } else {
        // Redirige si el producto no pertenece al usuario
        header('Location: my_products.php');
        exit;
    }
} else {
    // Redirige si no se proporciona un ID de producto
    header('Location: my_products.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .card {
        border-radius: 25px !important;
    }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Producto</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
            </div>
            <div class="mb-3">
             <label for="price" class="form-label">Precio (CLP):</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" 
           pattern="[0-9]{1,8}" title="Ingresa un precio en pesos chilenos (máximo 8 dígitos)" required>
    </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
    
</body>
</html>

