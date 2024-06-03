<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoriler</title>
    <style>
        .product {
            border: 1px solid #ddd;
            padding: 40px;
            margin: 30px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            font-family: sans-serif;
            text-align: center;
        }
        .product img {
            max-width: 300px;
            height: auto;
            margin-right: 70px;
        }
        .product p {
            margin: 0;
        }

    </style>
</head>
<body>
<?php
include 'header.php';
global $conn;
include 'baglan.php';

$sql = "SELECT * FROM favorites";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<img src='" . $row["image_url"] . "' alt='Product Image'>";
        echo "<div>";
        echo "<p>" . $row["description"] . "</p>";
        echo "<br>";
        echo "<p>" . $row["price"] . " $</p>";
        echo "</div> ";
        echo "<button onclick='removeFromFavorites(" . $row["id"] . ") ' style='font-size: 20px; border-radius: 8px; background-color: #327ccc; color: white; margin: 5px;'>Delete</button>";
        echo "</div>";
    }
} else {
    echo "Favori ürün bulunamadı.";
}
$conn->close();
?>
<script>
    function removeFromFavorites(productId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "Success") {
                    location.reload();
                } else {
                    alert("Ürünü favorilerden silme işleminde bir hata oluştu.");
                }
            }
        };
        xhttp.open("POST", "remove_from_favorites.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + productId);
    }
</script>
</body>
</html>
