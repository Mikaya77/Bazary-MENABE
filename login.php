<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vente";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, username, password, role FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $username, $hashed_password, $role);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role == 'admin') {
                header('Location: admin_manage_products.php');
            } else {
                header('Location: accueil.php');
            }
            exit();
        } else {
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $message = "Erreur SQL : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            width: 100%;
            animation: fadeIn 0.8s ease-in-out;
        }
        .navbar-brand {
            color: white !important;
            font-size: 1.5em;
            font-weight: bold;
        }
        .form-group label {
            color: #333;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .footer {
            color: white;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .ss {
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.html">Bazary Fia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>

        <!-- Login Section -->
        <div class="container mt-5">
            <h2 class="ss" id="ss">Connexion</h2>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Votre email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="password" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="Se Connecter" name="valid">
                     <br> <center>  <a href="signup.html" class="link">S'inscrire?</a></center>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="Assets2/JS/all.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/popper.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/bootstrap.min.js"></script>
</body>
</html>
