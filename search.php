<?php
// search.php
$servername = '185.98.131.128';
$username = 'nsivi1376823_61swty2';
$password = 'Estia!2025';

$conn = new mysqli($servername, $username, $password);
mysqli_select_db($conn, $username);

$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

// Requête pour rechercher dans les titres et descriptions
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
WHERE films.titre LIKE '%$searchTerm%' 
   OR films.description LIKE '%$searchTerm%'
   OR genres.nom LIKE '%$searchTerm%'
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinéstia - Résultats de recherche</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .films-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }
        
        .film-card {
            background-color: #111119;
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.2s;
        }
        
        .film-card:hover {
            transform: translateY(-4px);
        }
        
        .film-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        
        .film-info {
            padding: 16px;
        }
        
        .film-info h3 {
            margin-bottom: 8px;
            font-size: 16px;
        }
        
        .film-info p {
            color: #c7c7c7;
            font-size: 14px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <a href="index.php" class="logo">Cinéstia</a>
        <form class="search-bar" action="search.php" method="get">
            <input type="text" placeholder="Rechercher un film..." name="q" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">🔍</button>
        </form>
        <nav class="nav-links">
            <a href="toutfilms.php">Films</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="connexion.html" class="btn-connexion">Connexion</a>
        </nav>
    </header>

    <main>
        <section class="films-section">
            <h1>Résultats pour "<?php echo htmlspecialchars($searchTerm); ?>"</h1>
            <?php if ($result->num_rows > 0): ?>
                <div class="films-grid">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <article class="film-card">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['titre']); ?>">
                            <div class="film-info">
                                <h3><?php echo htmlspecialchars($row['titre']); ?></h3>
                                <p><?php echo htmlspecialchars($row['genre']); ?> • <?php echo htmlspecialchars($row['annee']); ?></p>
                                <button class="btn-wishlist" data-film-id="<?php echo $row['id']; ?>">
                                    Ajouter à ma wishlist
                                </button>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p style="text-align: center; padding: 40px; color: #c7c7c7;">
                    Aucun film trouvé pour "<?php echo htmlspecialchars($searchTerm); ?>"
                </p>
            <?php endif; ?>
        </section>
    </main>

    <script src="js/script.js"></script>
</body>
</html>
<?php
$conn->close();
?>
