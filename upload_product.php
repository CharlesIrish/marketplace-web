<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT name FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$nombre_usuario = $user['name'];
$sql = "SELECT photo FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$photo = $user['photo'] ? './uploads/' . $user['photo'] : 'default-profile.png';

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (user_id, name, price, description, image) VALUES ('$user_id', '$name', '$price', '$description', '$image')";
        if (mysqli_query($conn, $sql)) {
            $message = "Producto subido exitosamente.";
            $message_type = "success";
        } else {
            $message = "Error al subir el producto: " . mysqli_error($conn);
            $message_type = "danger";
        }
    } else {
        $message = "Error al subir la imagen.";
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
</head>
<body>
<nav class="navbar bg-success p-4">
    <div class="container d-flex flex-wrap align-items-center justify-content-between">
    <a class="navbar-brand d-flex align-items-center" href="home.php" style="color:white; font-family:Inter; font-weight:bold;">
    <i class="bi bi-shop"></i>
    <span style="font-size: 80%; margin-left: 5px;">Marketplace</span>
</a>

<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 text-center ms-auto">
    <li><a style="font-family: Inter; font-weight: bold; margin-right: 24px;" href="#" class="nav-link px-2 link-light">Inventory</a></li>
    <li><a style="font-family: Inter; font-weight: bold; margin-right: 24px;" href="#" class="nav-link px-2 link-light">Customers</a></li>
    <li><a style="font-family: Inter; font-weight: bold; margin-right: 24px;" href="#" class="nav-link px-2 link-light">Products</a></li>
</ul>



        

        <div class="dropdown text-end">
            <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $photo; ?>" alt="Foto de Perfil" width="32" height="32" class="rounded-circle">
                <span style="margin-left: 2px; font-family: Inter; color: white; font-weight: bold;"><?php echo $nombre_usuario; ?></span>
            </a>
            <ul class="dropdown-menu text-small">
                <li><a class="dropdown-item" href="configuracion.php">Config</a></li>
                <li><a class="dropdown-item" href="home.php">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Salir</a></li>
            </ul>
            
        </div>
    </div>
</nav>
    <br><br>
    <div class="container" data-aos="zoom-in">
        <h2 style="font-family: Inter; font-weight: bold;" class="text-center">
            Vende tu producto
            <i class="bi bi-shop text-success"></i>
        </h2>
        <hr>
        <div class="text-center">
        <a style="font-family:Inter; font-size:14px;" href="home.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-shop"></i> Marketplace
    </a>
    <a style="font-family:Inter; font-size:14px;" href="my_products.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-person"></i> Mis Productos
    </a>
    <a style="font-family:Inter; font-size:14px;" href="create_auction.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-hammer"></i> Subastar
    </a>
    </div>
        <br><br>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="container col-xl-6 col-lg-8 col-md-10">
            <form method="post" action="upload_product.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label style="font-family: Inter; font-weight: bold;" for="name" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label style="font-family: Inter; font-weight: bold;" for="price" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label style="font-family: Inter; font-weight: bold;" for="description" class="form-label">Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label style="font-family: Inter; font-weight: bold;" for="image" class="form-label">Foto</label>
                    <input style="font-family: Inter; font-weight: bold;" type="file" class="form-control" id="image" name="image" required>
                </div>
                <button style="font-family: Inter; font-size:14px;" type="submit" class="btn btn-success">Subir Producto</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
