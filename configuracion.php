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

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
$products = array();
while ($product = mysqli_fetch_assoc($result)) {
    $products[] = $product;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <style>
        /* Estilo para cards */
        .card {
            height: 100%;
        }
        /* Estilo para descripción con scroll horizontal */
        .card-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
<nav class="navbar bg-success p-4">
    <div class="container d-flex flex-wrap align-items-center justify-content-between">
        <a class="navbar-brand d-flex align-items-center" href="home.php" style="color:white; font-family:Inter; font-weight:bold;">
            <i class="bi bi-shop"></i>
            <span style="font-size: 80%; margin-left: 5px;"></span>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a style="font-family: Inter; font-weight: bold;" href="#" class="nav-link px-2 link-light">Overview</a></li>
            <li><a style="font-family: Inter; font-weight: bold;" href="#" class="nav-link px-2 link-light">Inventory</a></li>
            <li><a style="font-family: Inter; font-weight: bold;" href="#" class="nav-link px-2 link-light">Customers</a></li>
            <li><a style="font-family: Inter; font-weight: bold;" href="#" class="nav-link px-2 link-light">Products</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
            <input id="searchInput" type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
            <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $photo; ?>" alt="Foto de Perfil" width="32" height="32" class="rounded-circle">
                <span style="margin-left: 2px; font-family: Inter; color: white; font-weight: bold;"><?php echo $nombre_usuario; ?></span>
            </a>
            <ul class="dropdown-menu text-small">
                <li><a class="dropdown-item" href="home.php">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Salir</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container" data-aos="zoom-in">
    <br><br>
    <h2 style="font-family: Inter; font-weight: bold; text-align:center;">
        Configuracion
        <i class="bi bi-shop text-success"></i>
    </h2>
    <hr>
    <?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?php echo strpos($_SESSION['message'], 'Error') !== false ? 'danger' : 'success'; ?> alert-dismissible fade show" role="alert">
        <i class="bi <?php echo strpos($_SESSION['message'], 'Error') !== false ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill'; ?> me-2"></i>
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php } ?>

    <div class="text-center">
    <a style="font-family:Inter;  font-size:14px;" href="home.php" class="btn btn-outline-success mt-2">
            <i class="bi bi-shop"></i> Marketplace
        </a>
        <a style="font-family:Inter;  font-size:14px;" href="upload_product.php" class="btn btn-outline-success mt-2">
            <i class="bi bi-upload"></i> Subir Producto
        </a>
        <a style="font-family:Inter; font-size:14px;" href="my_products.php" class="btn btn-outline-success mt-2">
            <i class="bi bi-person"></i> Mis Productos
        </a>
        <a style="font-family:Inter; font-size:14px;" href="create_auction.php" class="btn btn-outline-success mt-2">
            <i class="bi bi-hammer"></i> Subastar
        </a>
    </div>
    <br>

    <div class="container col-xl-6 col-lg-8 col-md-10">
    <form method="post" action="update_user.php" enctype="multipart/form-data">
       
    <div class="mb-3">
            <label style="font-family: Inter; font-weight: bold;" for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $nombre_usuario; ?>" required>
        </div>
        <div class="mb-3">
            <label style="font-family: Inter; font-weight: bold;" for="photo" class="form-label" >Foto de Perfil</label>
            <input type="file" class="form-control" id="photo" name="photo"  required>
        </div>
        <button style="font-size:15px;" type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    AOS.init();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Espera a que el documento esté completamente cargado
    document.addEventListener("DOMContentLoaded", function() {
        // Obtiene el elemento del botón "Salir"
        var btnSalir = document.querySelector('a[href="logout.php"]');
        
        // Agrega un evento de clic al botón "Salir"
        btnSalir.addEventListener("click", function(event) {
            // Previene el comportamiento predeterminado del enlace
            event.preventDefault();
            
            // Muestra un SweetAlert de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Estás a punto de cerrar sesión!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión'
            }).then((result) => {
                // Si el usuario confirma, redirige a logout.php para cerrar sesión
                if (result.isConfirmed) {
                    window.location.href = btnSalir.href;
                }
            });
        });
    });
</script>

</body>
</html>
