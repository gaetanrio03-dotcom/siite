<?php
$host = "185.98.131.128";
$user = "nsivi1376823_61swty2";
$pass = "Estia!2025";

$conn = new mysqli($host, $user, $pass);

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];

mysqli_select_db($conn, $user);
$sql = "INSERT INTO `users` (`id`, `nom`, `email`, `mot_de_passe`, `created_at`) VALUES (NULL, '$name', '$email', '$password', current_timestamp());";

$conn->query($sql);

$conn->close();
?>
<meta http-equiv="refresh" content="0; URL=https://nsi-villapia.fr/projet_18/index.php">