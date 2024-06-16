<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vente";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Vérifier si une image a été téléchargée
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $image);

        if ($stmt->execute()) {
            echo "Produit ajouté avec succès";
        } else {
            echo "Erreur : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Veuillez télécharger une image.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/all.min.css">
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Ajouter un produit</h2>
        <form action="admin_add_product.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nom du produit</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Prix</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="image">Image du produit</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le produit</button>
        </form>
    </div>
    <br><br>
        <!-- Footer -->
        <footer class="footer text-center">
        <p>&copy; 2024 Bazary à MENABE. mikayavalimbavaka@gmail.com</p>
    </footer>
</body>
</html>
