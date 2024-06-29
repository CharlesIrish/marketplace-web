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

// Modifica la consulta para seleccionar solo los productos del usuario conectado
$sql = "SELECT * FROM products WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <style>

.card {
            height: 100%;
           border-radius: 25px !important;
        }
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
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
                <li><a class="dropdown-item" href="configuracion.php">Config</a></li>
                <li><a class="dropdown-item" href="home.php">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Salir</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <br><br>
    <h2 style="font-family: Inter; font-weight: bold; text-align:center;" >
        Mis Ventas
        <i class="bi bi-shop text-success"></i>
    </h2>
    <hr>
    <div class="text-center">
    <a style="font-family:Inter;  font-size:14px;" href="home.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-shop"></i> Marketplace
    </a>
    <a style="font-family:Inter; font-size:14px;" href="upload_product.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-upload"></i> Subir Producto
    </a>
    <a style="font-family:Inter; font-size:14px;" href="create_auction.php" class="btn btn-outline-success mt-2">
        <i class="bi bi-hammer"></i> Subastar
    </a>
    </div>
    <br><br>
    <div class="row row-cols-1 row-cols-md-4 g-3">
    <?php while ($product = mysqli_fetch_assoc($result)) { ?>
        <div class="col">
            <div class="card mb-4" data-aos="zoom-in">
                <img style="border-radius: 25px !important;" src="uploads/<?php echo $product['image']; ?>" class="card-img-top w-100 h-100" alt="<?php echo $product['name']; ?>">
                <div class="card-body">
                    <h5 style="font-family:Inter; font-weight:bold; font-size:16px;" class="card-title"><?php echo $product['name']; ?></h5>
                    <hr>
                    <p style="font-family:Inter; font-weight:bold; color:green; font-size:14px; margin-bottom: 4px;">$<?php echo $product['price']; ?></p>
                    <p style="font-family:Inter; font-size:14px; margin-bottom: 10px;"><?php echo $product['description']; ?></p>

                    <form action="delete_product.php" method="POST" onsubmit="return confirmDelete(<?php echo $product['id']; ?>);">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>"> 
                    <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Eliminar
        </button>
    </form>
    <button type="button" class="btn btn-success" onclick="editProduct(<?php echo $product['id']; ?>)">
                        <i class="bi bi-pencil"></i> Editar
                    </button>

                    <!--<button style="font-family:Inter; font-size:12px;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productModal" data-id="<?php echo $product['id']; ?>" data-name="<?php echo $product['name']; ?>" data-price="<?php echo $product['price']; ?>" data-description="<?php echo $product['description']; ?>" data-image="uploads/<?php echo $product['image']; ?>">
                        <i class="bi bi-eye"></i> Ver Detalles-->
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family:Inter;" class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="border-radius: 25px !important;">
                <img style="border-radius: 25px !important;" id="modalImage" src="" class="img-fluid mb-3" alt="Producto">
                <h5 style="font-family:Inter; font-weight:bold;" id="modalName"></h5>
                <hr>
                <p style="font-family:Inter; font-weight:bold; color:green; font-size:14px; margin-bottom: 4px;" id="modalPrice" class="text-success"></p>
                <p style="font-family:Inter; font-size:14px; margin-bottom: 10px;"  id="modalDescription"></p>
            </div>
            <div class="modal-footer">
                <button style="font-family:Inter; font-size:14px;" type="button" class="btn btn-success">
                    <i class="bi bi-pencil"></i> Editar
                </button>
                <button style="font-family:Inter; font-size:14px;" type="button" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
                <button style="font-family:Inter; font-size:14px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var productModal = document.getElementById('productModal');
    productModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var price = button.getAttribute('data-price');
        var description = button.getAttribute('data-description');
        var image = button.getAttribute('data-image');

        var modalTitle = productModal.querySelector('.modal-title');
        var modalName = productModal.querySelector('#modalName');
        var modalPrice = productModal.querySelector('#modalPrice');
        var modalDescription = productModal.querySelector('#modalDescription');
        var modalImage = productModal.querySelector('#modalImage');

        modalTitle.textContent = name;
        modalName.textContent = name;
        modalPrice.textContent = '$' + price;
        modalDescription.textContent = description;
        modalImage.src = image;
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
         function editProduct(productId) {
        window.location.href = 'edit_product.php?id=' + productId; // Corregido el nombre del archivo
    }





        function confirmDelete(productId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar el formulario si el usuario confirma
            document.querySelector('form[action="delete_product.php"] input[name="id"][value="' + productId + '"]').parentElement.submit();
        } 
    });
    return false; // Evitar que el formulario se envíe automáticamente
}

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
