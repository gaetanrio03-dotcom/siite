<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinéstia - Accueil</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <a href="index.php" class="logo">Cinéstia</a>

    <!-- Dans index.php, modifie la barre de recherche -->
    <form class="search-bar" action="search.php" method="get">
    <input type="text" placeholder="Rechercher un film..." name="q">
    <button type="submit">🔍</button>
    </form>


    <nav class="nav-links">
      <a href="toutfilms.php">Films</a>
      <a href="wishlist.html">Wishlist</a>
      <a href="connexion.html" class="btn-connexion">Connexion</a>
    </nav>
  </header>

  <main>
    <!-- HERO -->
    <section class="hero">
      <div class="hero-content">
        <h1>Votre wishlist cinéma</h1>
        <p>
          Explorez les films à l’affiche, ajoutez-les à votre wishlist
          et préparez vos prochaines séances comme au cinéma.
        </p>
        <a href="toutfilms.php" class="btn-primary">Voir tous les films</a>
      </div>
    </section>

    <!-- CARROUSEL -->
    <section class="carousel-section">
      <h2>À l'affiche</h2>
      <div class="carousel-container">
        <button class="carousel-btn prev" id="carousel-prev">❮</button>
        <div class="carousel" id="carousel">
          <?php include "carousel.php"?>
        </div>
        <button class="carousel-btn next" id="carousel-next">❯</button>
      </div>
    </section>

    <!-- APERÇU WISHLIST -->
    <section class="films-section">
      <h2>Commencez votre wishlist</h2>
      <p class="section-subtitle">
        Ajoutez quelques films pour commencer. Vous les retrouverez ensuite
        dans l’onglet <strong>Wishlist</strong>.
      </p>

      <div class="films-grid">
        <?php include "films.php"?>
      </div>
    </section>
  </main>

  <footer class="footer">
    <p>© 2025 Cinéstia - Projet wishlist cinéma</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
