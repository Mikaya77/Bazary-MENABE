<?php
session_start();

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vente";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, description, price, image FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Bazary à MENABE</title>
    <link rel="stylesheet" href="Assets2/CSS/bootstrap.css">
    <link rel="stylesheet" href="Assets2/CSS/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            margin-bottom: 30px;
            background-color: #007bff;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
        }
        .navbar-toggler-icon {
            filter: invert(1);
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        h1 {
            font-size: 2.5em;
        }
        h2 {
            font-size: 2em;
        }
        .card {
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
            border-radius: 10px;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.2s ease-in-out;
        }
        .card:hover .card-img-top {
            transform: scale(1.1);
        }
        .card-body {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
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
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card {
            animation: fadeInUp 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="accueil.php">Bazary </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Panier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Bienvenue à Bazary MENABE</h1>
        <h2>Nos Produits</h2>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p class="card-text">Prix: ' . htmlspecialchars($row['price']) . ' Ar</p>';
                    echo '<form action="cart.php" method="post">';
                    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" class="btn btn-primary">Ajouter au panier</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Aucun produit trouvé.";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <br><br>
        <!-- Footer -->
        <footer class="footer text-center">
        <p>&copy; 2024 Bazary à MENABE. mikayavalimbavaka@gmail.com</p>
    </footer>
    <script type="text/javascript" src="Assets2/JS/all.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/popper.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/bootstrap.min.js"></script>
</body>
</html>
