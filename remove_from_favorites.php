<?php
global $conn;
session_start();
include 'baglan.php';

if (isset($_POST['id'])) {
    $productId = $_POST['id'];


    $sql = "DELETE FROM favorites WHERE id = $productId";

    if ($conn->query($sql) === TRUE) {

        echo "Success";
    } else {

        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Hatalı istek!";
}
?>
