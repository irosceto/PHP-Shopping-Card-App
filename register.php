<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
 <style>
        html, body, .vh-100, .mask, .container, .row, .col-12, .card, .card-body {
            height: 100%;
            margin: 0;
            padding: 0;

        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .register-card {
            border-radius: 15px;
            width: 90%;
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .register-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }
label {
    display: block; 
    float: left; 
     width: 100px;
}
    </style>
</head>
<body>
<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$database="project";

	

$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sorgu="CREATE TABLE users( id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
)";
if ($conn->query($sorgu) === TRUE) {
    echo "Table created successfully";
} else {
    error_log("Error creating table: " . $conn->error);
}


if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {

// Formdan gelen kullanıcı adı ve şifre
$username = $_POST['username'];
$password = $_POST['password'];
$email=$_POST['email'];



$sql = "INSERT INTO users (username, password , email)  VALUES ('$username', '$password','$email')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
 } else {
    error_log("Form data is missing");
}

$conn->close();
?>

<section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
         <div class="register-container">
    <div class="register-card">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>
              <form action="register.php" method="POST">

              

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="username" name="username" class="form-control form-control-lg" />
                  <label class="form-label" for="username">Your Name</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" id="email" name="email" class="form-control form-control-lg" />
                  <label class="form-label" for="email">Your Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" id="password" name="password" class="form-control form-control-lg" />
                  <label class="form-label" for="password">Password</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" id="repeat_password" class="form-control form-control-lg" />
                  <label class="form-label" for="repeat_password">Repeat your password</label>
                </div>

              

                <div class="d-flex justify-content-center">
                  <button  type="submit" 
                     class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="#!"
                    class="fw-bold text-body"><u>Login here</u></a></p>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>


