// ===========================
//  GESTION DU CARROUSEL
// ===========================
function initCarousel() {
  const carousel = document.querySelector(".carousel");
  const prevBtn = document.querySelector(".carousel-btn.prev");
  const nextBtn = document.querySelector(".carousel-btn.next");

  if (!carousel || !prevBtn || !nextBtn) return;

  prevBtn.addEventListener("click", () => {
    carousel.scrollBy({ left: -200, behavior: "smooth" });
  });

  nextBtn.addEventListener("click", () => {
    carousel.scrollBy({ left: 200, behavior: "smooth" });
  });
}

// ===========================
//  GESTION DE LA WISHLIST
// ===========================

// Récupérer la wishlist depuis localStorage
function getWishlist() {
  const data = localStorage.getItem("wishlist");
  return data ? JSON.parse(data) : [];
}

// Sauvegarder la wishlist dans localStorage
function saveWishlist(wishlist) {
  localStorage.setItem("wishlist", JSON.stringify(wishlist));
}

// Ajouter un film à la wishlist
function addToWishlist(filmId) {
  let wishlist = getWishlist();
  if (!wishlist.includes(filmId)) {
    wishlist.push(filmId);
    saveWishlist(wishlist);
    updateWishlistButtons();
    renderWishlistPage();
  }
}

// Retirer un film de la wishlist
function removeFromWishlist(filmId) {
  let wishlist = getWishlist();
  wishlist = wishlist.filter((id) => id !== filmId);
  saveWishlist(wishlist);
  updateWishlistButtons();
  renderWishlistPage();
}

// Vérifier si un film est dans la wishlist
function isInWishlist(filmId) {
  const wishlist = getWishlist();
  return wishlist.includes(filmId);
}

// ===========================
//  MISE À JOUR DES BOUTONS WISHLIST
// ===========================
function updateWishlistButtons() {
  const buttons = document.querySelectorAll(".btn-wishlist");
  
  buttons.forEach((button) => {
    const filmId = button.getAttribute("data-film-id");
    
    if (isInWishlist(filmId)) {
      button.textContent = "Retirer de ma wishlist";
      button.classList.add("in-wishlist");
    } else {
      button.textContent = "Ajouter à ma wishlist";
      button.classList.remove("in-wishlist");
    }
  });
}

// ===========================
//  CONFIGURATION DES BOUTONS WISHLIST
// ===========================
function setupWishlistButtons() {
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("btn-wishlist")) {
      const filmId = e.target.getAttribute("data-film-id");
      
      if (isInWishlist(filmId)) {
        removeFromWishlist(filmId);
      } else {
        addToWishlist(filmId);
      }
    }
  });
}

// ===========================
//  AFFICHAGE DE LA PAGE WISHLIST
// ===========================
function renderWishlistPage() {
  const container = document.querySelector(".wishlist-grid");
  const emptyState = document.querySelector(".empty-wishlist");

  if (!container) return;

  const wishlist = getWishlist();

  if (wishlist.length === 0) {
    container.style.display = "none";
    if (emptyState) emptyState.style.display = "block";
    return;
  }

  if (emptyState) emptyState.style.display = "none";
  container.style.display = "grid";
  container.innerHTML = "";

  // Récupérer les films depuis la base de données
  fetch("get_wishlist_films.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ ids: wishlist }),
  })
    .then((response) => response.json())
    .then((films) => {
      films.forEach((film) => {
        const card = createWishlistCard(film);
        container.appendChild(card);
      });
    })
    .catch((error) => {
      console.error("Erreur lors de la récupération des films:", error);
    });
}

// Créer une carte de film pour la wishlist
function createWishlistCard(film) {
  const article = document.createElement("article");
  article.className = "film-card";

  article.innerHTML = `
    <img src="${film.image}" alt="${film.titre}">
    <div class="film-info">
      <h3>${film.titre}</h3>
      <p>${film.genre} • ${film.annee}</p>
      <button class="btn-wishlist in-wishlist" data-film-id="${film.id}">
        Retirer de ma wishlist
      </button>
    </div>
  `;

  return article;
}

// ===========================
//  VIDER LA WISHLIST
// ===========================
function setupClearWishlist() {
  const clearBtn = document.querySelector(".btn-clear-wishlist");
  if (!clearBtn) return;

  clearBtn.addEventListener("click", () => {
    if (confirm("Êtes-vous sûr de vouloir vider votre wishlist ?")) {
      localStorage.removeItem("wishlist");
      renderWishlistPage();
      updateWishlistButtons();
    }
  });
}

// ===========================
//  GESTION DE LA RECHERCHE
// ===========================
function setupSearch() {
  const searchForm = document.querySelector(".search-bar");
  const searchInput = document.querySelector(".search-bar input[name='q']");

  if (!searchForm || !searchInput) return;

  searchForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const query = searchInput.value.trim().toLowerCase();

    if (query === "") {
      return;
    }

    // Rechercher dans tous les films
    searchFilms(query);
  });
}

function searchFilms(query) {
  // Récupérer tous les films depuis la base de données
  fetch("search_films.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ query: query }),
  })
    .then((response) => response.json())
    .then((films) => {
      displaySearchResults(films, query);
    })
    .catch((error) => {
      console.error("Erreur lors de la recherche:", error);
    });
}

function displaySearchResults(films, query) {
  // Cacher le carrousel et afficher les résultats
  const carouselSection = document.querySelector(".carousel-section");
  const filmsSection = document.querySelector(".films-section");

  if (carouselSection) {
    carouselSection.style.display = "none";
  }

  if (!filmsSection) return;

  // Créer ou mettre à jour la section de résultats
  let resultsSection = document.querySelector(".search-results-section");
  
  if (!resultsSection) {
    resultsSection = document.createElement("section");
    resultsSection.className = "search-results-section";
    resultsSection.style.maxWidth = "1200px";
    resultsSection.style.margin = "0 auto";
    resultsSection.style.padding = "32px 16px";
    
    if (filmsSection.parentNode) {
      filmsSection.parentNode.insertBefore(resultsSection, filmsSection);
    }
  }

  if (films.length === 0) {
    resultsSection.innerHTML = `
      <h2>Résultats de recherche pour "${query}"</h2>
      <p style="color: #c7c7c7; margin-top: 16px;">Aucun film trouvé pour votre recherche.</p>
    `;
    return;
  }

  resultsSection.innerHTML = `
    <h2>Résultats de recherche pour "${query}" (${films.length})</h2>
    <div class="films-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; margin-top: 24px;">
      ${films
        .map(
          (film) => `
        <article class="film-card">
          <img src="${film.image}" alt="${film.titre}">
          <div class="film-info">
            <h3>${film.titre}</h3>
            <p>${film.genre} • ${film.annee}</p>
            <button class="btn-wishlist ${
              isInWishlist(film.id.toString()) ? "in-wishlist" : ""
            }" data-film-id="${film.id}">
              ${
                isInWishlist(film.id.toString())
                  ? "Retirer de ma wishlist"
                  : "Ajouter à ma wishlist"
              }
            </button>
          </div>
        </article>
      `
        )
        .join("")}
    </div>
  `;
}

// ===========================
//  AFFICHER/MASQUER MOT DE PASSE
// ===========================
function setupPasswordToggle() {
  const toggleButtons = document.querySelectorAll(".toggle-password");

  toggleButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const input = button.previousElementSibling;
      if (input.type === "password") {
        input.type = "text";
        button.textContent = "🙈";
      } else {
        input.type = "password";
        button.textContent = "👁️";
      }
    });
  });
}

// ===========================
//  INITIALISATION GLOBALE
// ===========================
document.addEventListener("DOMContentLoaded", () => {
  initCarousel();
  setupWishlistButtons();
  updateWishlistButtons();
  renderWishlistPage();
  setupClearWishlist();
  setupPasswordToggle();
  setupSearch();
});
