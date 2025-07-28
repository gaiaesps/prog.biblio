<?php
// Collegamento al database
require_once './configurazione.php';
require_once './database.php';
session_start();
date_default_timezone_set('Europe/Rome');
if (isset($_GET['return'])) {
    $_SESSION['return_url'] = $_GET['return'];
}

date_default_timezone_set('Europe/Rome');

$conn = openconnection();
$ora = time();

// Sblocca tutti i libri scaduti nel database
$stmt = $conn->prepare("UPDATE collocati SET disponibilita = 1, bloccato_fino = NULL WHERE disponibilita = 0 AND bloccato_fino <= ?");
$stmt->bind_param("i", $ora);
$stmt->execute();
$stmt->close();

// Rimuove anche i libri scaduti dalla sessione
if (isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = array_filter($_SESSION['carrello'], function ($item) use ($ora) {
        return $item['bloccato_fino'] > $ora;
    });
}

$sql = "
SELECT
  libri.nome AS titolo,
  MIN(libri.codice_libro) AS codice_libro,
  MIN(libri.copertina) AS copertina,
  MIN(autori.nome) AS autore,
  MAX(collocati.disponibilita) AS disponibilita
FROM libri
JOIN autori ON libri.autori_id_autori = autori.id_autori
JOIN collocati ON collocati.libri_codice_libro = libri.codice_libro
GROUP BY libri.nome
";
;
$result = $conn->query($sql);
$session_timeout = 7200;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['conferma_logout'])) {
    $return_url = $_SESSION['return_url'] ?? 'login.php';

    // Sicurezza: consenti solo URL interni
    if (strpos($return_url, '/') !== 0) {
        $return_url = 'login.php';
    }

    session_unset();
    session_destroy();
    header("Location: $return_url");
    exit();
}


if (isset($_SESSION['id_cliente']) && isset($_SESSION['login_time'])) {
    if (time() - $_SESSION['login_time'] > $session_timeout) {
        session_unset();
        session_destroy();
        header("Location: login.php?timeout=1");
        exit();
    } else {
        $_SESSION['login_time'] = time(); // rinnova la sessione
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <title>Catalogo Libri</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <style>
    .catalog-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
    .filter-bar { margin-bottom: 30px; text-align: right; }
    .filter-bar select { padding: 8px 12px; font-size: 15px; border-radius: 6px; border: 1px solid #ccc; }
    .book-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; }
    .book-card { background-color: white; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center; transition: transform 0.2s ease; }
    .book-card:hover { transform: scale(1.02); }
    .book-card img { width: 100%; height: 220px; object-fit: cover; }
    .book-info { padding: 15px; }
    .book-info h4 { font-size: 16px; margin: 10px 0 5px; }
    .book-info p { margin: 0; font-size: 14px; color: #555; }
    .book-unavailable { opacity: 0.5; position: relative; }
    .book-unavailable::after { content: "IN PRESTITO"; position: absolute; top: 10px; left: 10px; background-color: #A22522; color: white; padding: 4px 8px; font-size: 12px; border-radius: 5px; }
    .dropdown {position: relative;display: inline-block;}
    .dropdown-button {padding: 10px 20px;background-color: #A22522;color: white;border: none;cursor: pointer;border-radius: 25px;font-size: 15px;display: flex;align-items: center;gap: 8px;}
    .dropdown-content {display: none;position: absolute;background-color: white;min-width: 160px;box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);border-radius: 8px;padding: 10px 0;z-index: 999;top: 110%;left: 0;}
    .dropdown-content a {color: #333;padding: 10px 20px;text-decoration: none;display: block;}
    .dropdown-content a:hover {background-color: #f5f5f5;}
    .dropdown:hover .dropdown-content {display: block;}
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .confirm-box {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.4);
      text-align: center;
      max-width: 400px;
    }

    .confirm-box h3 {
      margin-bottom: 20px;
    }

    .confirm-box form {
      display: inline-block;
      margin: 0 10px;
    }

    .confirm-box button {
      padding: 10px 20px;
      border-radius: 25px;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .btn-si {
      background-color: #A22522;
      color: white;
    }

    .btn-no {
      background-color: #ccc;
      color: #333;
    }

    .btn-si:hover {
      background-color: #7e1d1c;
    }

    .btn-no:hover {
      background-color: #aaa;
    }
    .auth-buttons .btn {
      background-color: #2A2B2E;
      color: white;
      padding: 10px 16px;
      border-radius: 25px;
      text-decoration: none;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: background-color 0.2s ease;
    }

    .auth-buttons .btn:hover {
      background-color: #1f1f22;
    }
  </style>
</head>
<header>
<div class="container" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 40px;">


  <div class="menu">
    <div class="dropdown">
      <button class="dropdown-button"><i class="fas fa-bars"></i> Menu</button>
      <div class="dropdown-content">
        <a href="home.php">Home</a>
        <?php if (isset($_SESSION['id_cliente'])): ?>
          <a href="area-personale.php">Area Personale</a>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <div class="auth-buttons">
    <?php if (isset($_SESSION['id_cliente'])): ?>
      <div style="display: flex; align-items: center; gap: 20px;">
  <span style="font-size: 16px;">Ciao, <?= htmlspecialchars($_SESSION['nome']) ?> 👋</span>
  <a href="carrello.php" style="display: flex; align-items: center;">
      <img src="carrellosito.png" alt="Carrello" style="width: 60px; height: 60px;">
  </a>

  <a href="<?= $_SERVER['PHP_SELF'] ?>?logout=1&return=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn">Logout</a>
  </div>
    <?php else: ?>
      <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login</a>
    <?php endif; ?>
  </div>

</div>
</header>

<body>
  <main class="catalog-container">
    <div class="filter-bar">
      <label for="filter">Filtra per disponibilità:</label>
      <select id="filter" onchange="filterBooks()">
        <option value="all">Tutti</option>
        <option value="available">Disponibili</option>
        <option value="unavailable">In prestito</option>
      </select>
    </div>

    <div class="book-grid" id="bookGrid">
      <div class="book-grid" id="bookGrid">
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <?php
              $class = $row["disponibilita"] ? "available" : "unavailable book-unavailable";
              $copertina = htmlspecialchars($row["copertina"]);
              $titolo = htmlspecialchars($row["titolo"]);
              $autore = htmlspecialchars($row["autore"]);
              $id = urlencode($row["codice_libro"] ?? '');
            ?>
            <a href="libro.php?id=<?= $id ?>" class="book-card <?= $class ?>">
              <img src="<?= $copertina ?>" alt="<?= $titolo ?>">
              <div class="book-info">
                <h4><?= $titolo ?></h4>
                <p><?= $autore ?></p>
              </div>
            </a>
          <?php endwhile; ?>
        <?php else: ?>
          <p>Nessun libro trovato nel database.</p>
        <?php endif; ?>
</div>


  </main>

  <footer>
    <p>&copy; 2025 Biblioteca Comunale</p>
  </footer>

  <script>
    function filterBooks() {
      const filter = document.getElementById("filter").value;
      const books = document.querySelectorAll(".book-card");

      books.forEach(book => {
        if (filter === "all") {
          book.style.display = "block";
        } else if (filter === "available" && book.classList.contains("available")) {
          book.style.display = "block";
        } else if (filter === "unavailable" && book.classList.contains("unavailable")) {
          book.style.display = "block";
        } else {
          book.style.display = "none";
        }
      });
    }
  </script>
  <?php if (isset($_GET['logout'])): ?>
    <div class="overlay">
      <div class="confirm-box">
        <h3>Sei sicuro di voler effettuare il logout?</h3>
        <form method="post">
          <input type="hidden" name="conferma_logout" value="1">
          <button type="submit" class="btn-si">Sì</button>
        </form>
        <form method="get">
          <button type="submit" class="btn-no">No</button>
        </form>
      </div>
    </div>
  <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
