<?php
session_start();

$host = "185.98.131.128";
$user = "nsivi1376823_61swty2";
$pass = "Estia!2025";

// Connexion MySQL
$conn = new mysqli($host, $user, $pass);

// Vérification connexion
if ($conn->connect_error) {
    die("Erreur de connexion");
}

// Sélection de la base de données
mysqli_select_db($conn, $user);

// Récupération des données du formulaire
$email = $_POST["email"];
$password = $_POST["password"];

// Requête de vérification
$sql = "SELECT * FROM users WHERE email = '$email' AND mot_de_passe = '$password'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    // Utilisateur trouvé
    $userData = $result->fetch_assoc();

    $_SESSION["user_id"] = $userData["id"];
    $_SESSION["user_name"] = $userData["nom"];
    $_SESSION["user_email"] = $userData["email"];

    // Redirection après connexion
    header("Location: https://nsi-villapia.fr/projet_18/index.html");
    exit;
} else {
    // Échec connexion
    echo "Email ou mot de passe incorrect";
}

$conn->close();
?>
