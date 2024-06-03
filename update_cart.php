<?php
session_start();
require_once 'baglan.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
        echo "Success";
    } else {
        echo "The product was not found!";
    }
} else {
    echo "Wrong request!";
}
?>