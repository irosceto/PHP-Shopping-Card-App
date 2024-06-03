<?php
global $conn;
session_start();
include 'baglan.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = array(
            'id' => $productId,
            'description' => $product['description'],
            'price' => $product['price'],
            'quantity' => $quantity
        );
    }
    echo "Success";
} else {
    echo "Wrong request!";
}
?>