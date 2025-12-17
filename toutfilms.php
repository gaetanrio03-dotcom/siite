<?php
$servername = '185.98.131.128';
$username   = 'nsivi1376823_61swty2';
$password   = 'Estia!2025';

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

mysqli_select_db($conn, $username);

// Récupérer la recherche
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

// Requête de base
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

if ($search !== '') {
    $sql .= ' WHERE films.titre LIKE ? 
              OR films.description LIKE ?
              OR genres.nom LIKE ?';
    $stmt = $conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bind_param('sss', $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinéstia - Tous les films</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <a href="index.php" class="logo">Cinéstia</a>

    <!-- BARRE DE RECHERCHE FONCTIONNELLE -->
    <form class="search-bar" action="toutfilms.php" method="get">
      <input
        type="text"
        placeholder="Rechercher un film..."
        name="q"
        value="<?php echo htmlspecialchars($search); ?>"
      >
      <button type="submit">🔍</button>
    </form>

    <nav class="nav-links">
      <a href="toutfilms.php">Films</a>
      <a href="wishlist.html">Wishlist</a>
      <a href="connexion.html" class="btn-connexion">Connexion</a>
    </nav>
  </header>

  <main class="films-page">
    <section class="films-section">
      <?php if ($search !== ''): ?>
        <h1>Résultats pour « <?php echo htmlspecialchars($search); ?> »</h1>
      <?php else: ?>
        <h1>Tous les films</h1>
      <?php endif; ?>

      <?php
      if (!$result || $result->num_rows === 0) {
          echo '<p>Aucun film ne correspond à votre recherche.</p>';
      } else {
          echo '<div class="films-grid">';
          while ($row = $result->fetch_assoc()) {
              echo '<article class="film-card">';
              echo '  <img src="' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["titre"]) . '">';
              echo '  <h3>' . htmlspecialchars($row["titre"]) . '</h3>';
              echo '  <p>' . htmlspecialchars($row["genre"]) . ' • ' . htmlspecialchars($row["annee"]) . '</p>';
              echo '  <button class="btn-wishlist"
                                data-film-id="' . htmlspecialchars($row["id"]) . '"
                                data-title="' . htmlspecialchars($row["titre"]) . '"
                                data-genre="' . htmlspecialchars($row["genre"]) . '"
                                data-image="' . htmlspecialchars($row["image"]) . '"
                                data-year="' . htmlspecialchars($row["annee"]) . '">
                        Ajouter à ma wishlist
                      </button>';
              echo '</article>';
          }
          echo '</div>';
      }
      $conn->close();
      ?>
    </section>
  </main>

  <footer class="footer">
    <p>© 2025 Cinéstia - Tous les films</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
