<?php
session_start();

// Vérifiez si le panier existe dans la session
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vente";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$total = 0;
$products = [];

if (!empty($_SESSION['cart'])) {
    // Récupérer les informations des produits dans le panier
    $product_ids = implode(",", $_SESSION['cart']);
    $sql = "SELECT id, name, price FROM products WHERE id IN ($product_ids)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
            $total += $row['price'];
        }
    }
}

// Simuler le paiement et vider le panier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vider le panier après le paiement
    $_SESSION['cart'] = [];

    $message = "Merci pour votre achat ! Veuillez effectuer le paiement au numéro suivant : 0332604496.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link rel="stylesheet" href="Assets2/CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #333;
            width: 100%;
            max-width: 600px;
            animation: fadeIn 0.8s ease-in-out;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-secondary, .btn-success {
            width: 100%;
            margin-bottom: 10px;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        footer {
            margin-top: 30px;
            text-align: center;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Paiement</h1>
        <a href="accueil.php" class="btn btn-secondary mb-3">Retour à l'accueil</a>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
            <p>Numéro de téléphone pour le paiement : <strong>0332604496</strong></p>
        <?php else: ?>
            <?php if (!empty($products)): ?>
                <form method="post">
                    <h3>Total: <?php echo $total; ?> Ar</h3>
                    <button type="submit" class="btn btn-success">Procéder au paiement</button>
                </form>
            <?php else: ?>
                <p>Votre panier est vide. <a href="cart.php">Retourner au panier</a></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script type="text/javascript" src="Assets2/JS/all.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/popper.min.js"></script>
    <script type="text/javascript" src="Assets2/JS/bootstrap.min.js"></script>
</body>
</html>
