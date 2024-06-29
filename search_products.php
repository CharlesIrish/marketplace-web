<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = $_POST['query'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    $output = '';
    while ($product = mysqli_fetch_assoc($result)) {
        $output .= '<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-3 product">';
        $output .= '<div class="card">';
        $output .= '<img src="uploads/' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">';
        $output .= '<div class="card-body">';
        $output .= '<h5 class="card-title">' . $product['name'] . '</h5>';
        $output .= '<p class="card-text">$' . $product['price'] . '</p>';
        $output .= '<p class="card-text">' . $product['description'] . '</p>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    }

    echo $output;
}
?>
