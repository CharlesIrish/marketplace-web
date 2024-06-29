<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Subasta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
</head>
<body>
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = $_POST['product_id'];
        $starting_price = $_POST['starting_price'];
        $end_time = $_POST['end_time'];

        $sql = "INSERT INTO auctions (product_id, starting_price, end_time) VALUES ('$product_id', '$starting_price', '$end_time')";
        if (mysqli_query($conn, $sql)) {
            echo "Subasta creada exitosamente.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    $sql = "SELECT * FROM products WHERE user_id = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    ?>

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

    <div class="container" data-aos="zoom-in">
        <br><br>
        <h2 style="font-family: Inter; font-weight: bold;" class="text-center">
            Subastas
            <i class="bi bi-hammer text-success"></i>
        </h2>
        <hr>
        <div class="text-center">
        <a style="font-family:Inter; font-size:14px;" href="home.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-shop"></i> Marketplace
    </a>
    <a style="font-family:Inter; font-size:14px;" href="my_products.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-person"></i> Mis Productos
    </a>
    <a style="font-family:Inter; font-size:14px;" href="upload_product.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-upload"></i> Subir Producto
    </a>
    </div>
 
        <br> <br> <br>
        <div class="container col-xl-6 col-lg-8 col-md-10">
            <form method="post" action="create_auction.php">
                <div class="mb-3">
                    <label  style="font-family: Inter; font-weight: bold;" for="product_id" class="form-label">Mis Productos</label>
                    <select style="font-family: Inter;" class="form-select" id="product_id" name="product_id" required>
                        <?php while ($product = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo $product['id']; ?>" data-price="<?php echo $product['price']; ?>"><?php echo $product['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label  style="font-family: Inter; font-weight: bold;" for="starting_price" class="form-label">Precio Inicial</label>
                    <input type="number" step="0.01" class="form-control" id="starting_price" name="starting_price" required>
                </div>
                <div class="mb-3">
                    <label  style="font-family: Inter; font-weight: bold;" for="end_time" class="form-label">Fecha de Finalización</label>
                    <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
                </div>
                <button style="font-size:15px;" type="submit" class="btn btn-success">Crear Subasta</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.getElementById('product_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var price = selectedOption.getAttribute('data-price');
            document.getElementById('starting_price').value = price;
        });
    </script>
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
