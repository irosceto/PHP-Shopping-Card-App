<?php
global $conn;
require_once 'baglan.php';
// Tabloyu oluştur
$sql_create_table = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    price DECIMAL(10, 2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL
)";
$sql = "SELECT id, description, price FROM products";
$result = $conn->query($sql);
if ($conn->query($sql_create_table) === TRUE) {
    //echo "Database created";
} else { 
    echo "Error: " . $conn->error;
}

$api_url = 'https://fakestoreapi.com/products';
$data_json = file_get_contents($api_url);

$data = json_decode($data_json, true);
if ($data) {
    foreach ($data as $item) {
        $category = $conn->real_escape_string($item['category']);
        $price = $item['price'];
        $description = $conn->real_escape_string($item['description']);
        $image_url = $item['image'];

        $sql_insert = "INSERT INTO products (price, description, image_url) 
                VALUES ( '$price', '$description', '$image_url')";

        if ($conn->query($sql_insert) === TRUE) {
            //echo "Yeni kayıt başarıyla eklendi: $description <br>";
        } else {
            echo "Hata: " . $sql_insert . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error fetching data from API.";
}
$sql_select_products = "SELECT * FROM products";
$result = $conn->query($sql_select_products);


$conn->close();


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
<?php
include 'header.php';
?>
<?php
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-card'>";
        echo "<img src='" . $row["image_url"] . "' alt='Product Image' class='product-image'>";
        echo "<p>Price: $" . $row["price"] . "</p>";
        echo "<p>Description: " . $row["description"] . "</p>";
        echo "<input type='number' id='quantity_" . $row["id"] . "' value='1' min='1'> ";
        echo "<button class='add-to-cart' data-id='" . $row["id"] . "'>Add To Cart</button>";
        echo "<button class='favorite-btn' data-id='" . $row["id"] . "'>Add To Favorite</button>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No products found in the database.";
}

?>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var cart = [];

    function addToCart(productId, price) {
        var quantity = parseInt(document.getElementById('quantity_' + productId).value);
        var subtotal = quantity * price;
        console.log('Product ID: ' + productId + ', Quantity: ' + quantity + ', Subtotal: $' + subtotal);


        cart.push({ productId: productId, quantity: quantity, subtotal: subtotal });


        console.log('Cart:', cart);


        calculateTotal();
    }

    function calculateTotal() {
        var total = 0;
        for (var i = 0; i < cart.length; i++) {
            total += cart[i].subtotal;
        }
        console.log('Total: $' + total);

    }
    $(document).ready(function() {
        $(".add-to-cart").click(function() {
            var id = $(this).data("id");
            $.post("add_to_cart.php", { id: id }, function(data) {
            });
        });
    });
    $(document).ready(function(){
        $('.favorite-btn').click(function(){
            var productId = $(this).data('id');

            $.ajax({
                url: 'add_to_favorites.php',
                type: 'POST',
                data: { id: productId },
                success: function(response) {
                    alert('The product has been added to the favorites!');
                },
                error: function() {
                    alert('An error has occurred.');
                }
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        var addToCartButtons = document.querySelectorAll('.add-to-cart');

        addToCartButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const quantity = document.getElementById('quantity_' + productId).value;
                addToCart(productId, quantity);
            });
        });
    });
    function addToCart(productId) {
        var quantity = document.getElementById('quantity_' + productId).value;
        if (quantity < 1) {
            alert("Please enter a valid amount.");
            return;
        }
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "add_to_cart.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + productId + "&quantity=" + quantity);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "Success") {
                    alert("The product has been added to the cart!");
                }
            }
        };
    }
</script>

</body>
</html>
