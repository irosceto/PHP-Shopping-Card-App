<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['id']);

    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        echo "Success";
    } else {
        echo "The product was not found!";
    }
} else {
    echo "Wrong request!";
}
?>