<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vente";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Suppression de produit
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id=$delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Produit supprimé avec succès";
    } else {
        echo "Erreur lors de la suppression du produit: " . $conn->error;
    }
}

// Récupérer les produits de la base de données
$sql = "SELECT id, name, description, price, image FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les produits</title>
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/all.min.css">
    <link rel="stylesheet" href="styless.css">
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
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Gérer les produits</h2>
        <a href="admin_add_product.php" class="btn btn-primary mb-3">Ajouter un produit</a>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $image_data = base64_encode($row['image']);
                    $image_src = 'data:image/jpeg;base64,' . $image_data;

                    echo '<div class="col-md-3 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="' . $image_src . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p class="card-text">Prix: ' . htmlspecialchars($row['price']) . ' Ar</p>';
                    echo '<a href="admin_edit_product.php?id=' . $row['id'] . '" class="btn btn-warning">Modifier</a>';
                    echo '<a href="admin_manage_products.php?delete_id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce produit ?\')">Supprimer</a>';
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
</body>
</html>
