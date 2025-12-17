<?php
$servername = '185.98.131.128';
$username = 'nsivi1376823_61swty2';
$password = 'Estia!2025';

$conn = new mysqli($servername, $username, $password);

mysqli_select_db($conn, $username);

// Requête avec jointure pour récupérer le nom du genre
$sql = '
SELECT 
    films.id,
    films.titre,
    films.image,
    films.description,
    films.annee,
    genres.nom AS genre
FROM films
JOIN genres ON films.genre_id = genres.id
';

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo '<article class="carousel-item">';
    echo '<div class="carousel-info">';
    echo '<h3>' . htmlspecialchars($row["titre"]) . '</h3>';
    echo '<img src="' . htmlspecialchars($row["image"]) . '">';
    echo '<p>' . htmlspecialchars($row["genre"]) . ' • ' . htmlspecialchars($row["annee"]) . '</p>';
    echo '<button class="btn-wishlist" data-film-id="' . htmlspecialchars($row["id"]) . '">';
    echo 'Ajouter à ma wishlist';
    echo '</button>';
    echo '</div>';
    echo '</article>';
}

$conn->close();
?>
