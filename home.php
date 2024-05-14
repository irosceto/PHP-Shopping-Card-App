

<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}



// Tabloyu oluştur
$sql_create_table = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    price DECIMAL(10, 2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL
)";

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

        $sql_insert = "INSERT INTO products (category, price, description, image_url) 
                VALUES ('$category', '$price', '$description', '$image_url')";

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

   if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       echo "<div class='product-card'>";
echo "<img src='" . $row["image_url"] . "' alt='Product Image' class='product-image'>";
echo "<p>Price: $" . $row["price"] . "</p>"; // Fiyatı ekleyin
echo "<p>Description: " . $row["description"] . "</p>";
echo "<div class='add-to-cart'>";
echo "<input type='number' id='quantity_" . $row["id"] . "' value='1' min='1'>";
echo "<button onclick='addToCart(" . $row["id"] . ", " . $row["price"] . ")'>Add to Cart</button>";
echo "</div>";
echo "</div>";
    }
} else {
    echo "No products found in the database.";
}

$conn->close();
?>


