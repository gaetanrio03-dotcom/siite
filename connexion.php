<?php
$host = "185.98.131.128";
$user = "nsivi1376823_61swty2";
$pass = "Estia!2025";

$conn = new mysqli($host, $user, $pass);

$email = $_POST["email"];
$password = $_POST["password"];

mysqli_select_db($conn, $user);

// Vérifier si l'email existe déjà
$check = "SELECT * FROM `users` WHERE `email` = '$email'";
$result = $conn->query($check);

if ($result->num_rows == 0) {
    // Insérer seulement si l'email n'existe pas
    $sql = "INSERT INTO `users` (`id`, `email`, `mot_de_passe`, `created_at`) 
            VALUES (NULL, '$email', '$password', current_timestamp());";
    $conn->query($sql);
}

// Redirection (toujours)
$conn->close();
?>
<meta http-equiv="refresh" content="0; URL=https://nsi-villapia.fr/projet_18/index.php">
