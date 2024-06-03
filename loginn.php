<?php
global $db;
session_start();
require_once 'baglan.php';
if($_POST) {
    // post işlemi yapılmış mı

    $username = addslashes($_POST["username"]);
    $password= addslashes($_POST["password"]);

    $prepare = $db->prepare("select * from users where username=:username &&  password=:password");

    $prepare->execute(array(
        "username" => $username,
        "password" => $password
    ));


    if($prepare->rowCount() > 0) {
        // bilgiler eşleşiyor oturum aç.
        $username = $prepare->fetch();

        $_SESSION["kid"] = $username["username"]; // oturum için kullanıcı id değerini tutmamız yeterli. bu id değeri ile diğer bilgilerine ulaşabiliriz.
        // index sayfasına yeniden yönlendir.
        header("Location: home.php");

    }else {
        $hata = " Kullanıcı adı veya şifre hatalı!";
    }

}

// çıkış yap

if(isset($_GET["islem"]) && $_GET["islem"] == "cikis") {
    session_destroy();
    // çıkış yap index sayfasına yeniden yönlendir.
    header("Location: loginn.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>
<body>


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
                                    <h2 class="text-uppercase text-center mb-5">Login</h2>
                                    <form method="post">
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="username" name="username"
                                                   class="form-control form-control-lg"/>
                                            <label class="form-label" for="username">Username</label>
                                        </div>
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="password" id="password" name="password"
                                                   class="form-control form-control-lg"/>
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit"
                                                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>


</script>
</body>
</html>

