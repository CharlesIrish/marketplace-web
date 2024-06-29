<?php
include('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: home.php');
    } else {
        $error = "Usuario no existe o contraseña incorrecta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        #container2 {
    margin: 50px auto; /* Esto centrará el contenedor horizontalmente */
    width: 400px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: white;
}


        .form-floating {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }

        .error {
            color: red;
            margin-top: 10px;
            font-family: Inter;
            font-weight: bold;
        }

        .icon {
            font-size: 2rem;
            margin-bottom: 20px;
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

        <a style="font-size:15px;" href="register.php" class="btn btn-outline-light">Registrarse</a>
    </div>
</nav>

<div class="container col-xl-10 col-xxl-8 px-4 py-5" data-aos="zoom-in">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Marketplace, Vende tus productos!</h1>
            <p class="col-lg-10 fs-4">Explora una amplia selección de productos únicos y encuentra todo lo que necesitas en un solo lugar. Nuestro marketplace te ofrece una experiencia de compra conveniente y segura. ¡Empieza a explorar hoy mismo!</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <div id="container2" class="text-center">
                <i class="bi bi-shop icon mb-3"></i>
                <h4 style="font-weight: bold; font-size: 22px;">Iniciar Sesión</h4>
                <br>
                <?php if(isset($error)) { ?>
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
                <?php } ?>
                <form style="font-size: 13px;" method="post" action="login.php">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required>
                        <label for="email">Correo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                        <label for="password">Contraseña</label>
                    </div>
                    <button style="font-size:15px;" type="submit" class="w-100 btn btn-lg btn-success">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<br><br><br><br><br><br><br><br>




<footer class="bg-success text-white text-center py-3">
    <i class="bi bi-shop icon mb-3 text-white"></i>
</footer>
<script>
        AOS.init();
    </script>


</body>
</html>
