<?php
session_start();

// Vérifiez si le panier existe dans la session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ajout d'un produit au panier
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if (!in_array($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product_id;
    }
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="Assets2/CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Votre Panier</h1>
        <a href="accueil.php" class="btn btn-secondary mb-3">Retour à l'accueil</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?> Ar</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="2">Votre panier est vide.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if (!empty($products)): ?>
            <h3>Total: <?php echo $total; ?> Ar</h3>
            <a href="checkout.php" class="btn btn-primary">Procéder au paiement</a>
        <?php else: ?>
            <a href="accueil.php" class="btn btn-secondary">Continuer vos achats</a>
        <?php endif; ?>
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
