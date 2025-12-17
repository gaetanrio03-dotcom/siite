<?php
$servername = '185.98.131.128';
$username = 'nsivi1376823_61swty2';
$password = 'Estia!2025';

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Erreur de connexion");
}

mysqli_select_db($conn, $username);

$sql = "
SELECT 
    films.id,
    films.titre,
    films.image,
    films.description,
    films.annee,
    genres.nom AS genre
FROM films
JOIN genres ON films.genre_id = genres.id
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo '<article class="film-card">';
    echo '<div class="film-content">';
    echo '<h3>' . htmlspecialchars($row["titre"]) . '</h3>';
    echo '<img src="' . htmlspecialchars($row["image"]) . '">';
    echo '<span class="film-meta">' . htmlspecialchars($row["genre"]) . '</span>';
    echo ' • ';
    echo '<span class="film-meta">' . htmlspecialchars($row["annee"]) . '</span>';
    echo '<p class="film-description">' . htmlspecialchars($row["description"]) . '</p>';
    echo '<button class="btn-wishlist" data-film-id="' . htmlspecialchars($row["id"]) . '">';
    echo 'Ajouter à ma wishlist';
    echo '</button>';
    echo '</div>';
    echo '</article>';
}

$conn->close();
?>
