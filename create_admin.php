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

// Définir les informations du nouvel administrateur
$admin_username = "admin";
$admin_email = "mika@gmail.com";
$admin_password = password_hash("mika", PASSWORD_DEFAULT); 
$admin_role = "admin";

// Insérer le nouvel administrateur dans la base de données
$sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $admin_username, $admin_email, $admin_password, $admin_role);

if ($stmt->execute()) {
    echo "Compte administrateur créé avec succès.";
} else {
    echo "Erreur : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
