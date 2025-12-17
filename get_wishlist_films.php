<?php
header('Content-Type: application/json');

$servername = '185.98.131.128';
$username = 'nsivi1376823_61swty2';
$password = 'Estia!2025';

$conn = new mysqli($servername, $username, $password);
mysqli_select_db($conn, $username);

// Récupérer les IDs depuis la requête POST
$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'] ?? [];

if (empty($ids)) {
    echo json_encode([]);
    exit;
}

// Sécuriser les IDs
$ids = array_map('intval', $ids);
$ids_string = implode(',', $ids);

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
WHERE films.id IN ($ids_string)
";

$result = $conn->query($sql);

$films = [];
while ($row = $result->fetch_assoc()) {
    $films[] = $row;
}

$conn->close();

echo json_encode($films);
?>

