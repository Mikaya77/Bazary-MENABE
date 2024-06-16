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

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id=$product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Produit non trouvé.";
        exit();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!empty($_FILES['image']['tmp_name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=? WHERE id=?");
        $stmt->bind_param("ssdi", $name, $description, $price, $id);
    }

    if ($stmt->execute()) {
        echo "Produit mis à jour avec succès";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_manage_products.php");
    exit();
} else {
    echo "Accès non autorisé.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="Assets2/CSS/all.min.css">
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier un produit</h2>
        <form action="admin_edit_product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <div class="form-group">
                <label for="name">Nom du produit</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Prix</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Image du produit</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <small>Si vous ne souhaitez pas modifier l'image, laissez ce champ vide.</small>
            </div>
            <button type="submit" class="btn btn-primary">Modifier le produit</button>
        </form>
    </div>
    <br><br>
        <!-- Footer -->
        <footer class="footer text-center">
        <p>&copy; 2024 Bazary à MENABE. mikayavalimbavaka@gmail.com</p>
    </footer>
</body>
</html>
