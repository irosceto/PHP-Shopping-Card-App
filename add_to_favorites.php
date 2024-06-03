<?php
global $conn;
include 'baglan.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['id'];

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        $stmt = $conn->prepare("INSERT INTO favorites (product_id, description, image_url, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $product['id'], $product['description'], $product['image_url'], $product['price']);

        if ($stmt->execute()) {
            echo "Ürün favorilere eklendi!";
        } else {
            echo "Hata: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Ürün bulunamadı.";
    }
}

$conn->close();
?>