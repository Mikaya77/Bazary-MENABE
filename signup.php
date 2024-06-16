<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation côté serveur
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email invalide.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Hashage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'vente');

    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // Insertion des données dans la base de données
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Inscription réussie !";
        header('location: signup_confirmation.html');
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
