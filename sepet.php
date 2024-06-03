<?php
session_start();
include 'header.php';
require_once 'baglan.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Cart İs Empty!";
} else {
    $total = 0;
    echo "<table border='1'>";
    echo "<tr><th>Delete</th><th>Description</th><th>Piece Price</th><th>Piece</th><th>Total Price</th></tr>";
    foreach ($_SESSION['cart'] as $product) {
        echo "<tr>";
        echo "<td>
                <button class='push_button red' style='margin: 12px;' onclick='removeFromCart(" . $product['id'] . ")'>Delete</button>
               
              </td>";
        echo "<td>" . htmlspecialchars($product['description']) . "</td>";
        echo "<td>" . htmlspecialchars($product['price']) . " $</td>";
        $subtotal = $product['price'] * $product['quantity'];
        echo "<td>
                <input type='number' value='" . $product['quantity'] . "' min='1' id='quantity_" . $product['id'] . "' onkeydown='if(event.key === \"Enter\") updateCart(" . $product['id'] . ")'>
              </td>";

        echo "<td id='subtotal_" . $product['id'] . "'>" . $subtotal . " $</td>";

        echo "</tr>";
        $total += $subtotal;
    }
    echo "<tr><td colspan='4' align='right'>Total</td><td>" . $total . " $</td><td></td></tr>";
    echo "</table>";
}
?>
<head>
    <link rel="stylesheet" media="screen" href="home.css">
    <link rel="stylesheet" href="sepet.css">
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
</head>
<body>
<script>
    function updateCart(productId) {
        var quantity = document.getElementById('quantity_' + productId).value;
        if (quantity < 1) {
            alert("Please enter a valid amount.");
            return;
        }
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "update_cart.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + productId + "&quantity=" + quantity);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "Success") {
                    location.reload();
                } else {
                    alert("An error occurred while updating the cart: " + this.responseText);
                }
            }
        };
    }

    function removeFromCart(productId) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "remove_from_cart.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + productId);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "Success") {
                    location.reload();
                } else {
                    alert("An error occurred while deleting the product from the cart: " + this.responseText);
                }
            }
        };
    }
</script>
</body>
