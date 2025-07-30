<?php
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
    $_SESSION['login_time'] = time();
  }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Biblioteca Comunale</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-button {
      padding: 10px 20px;
      background-color: #A22522;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 25px;
      font-size: 15px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      min-width: 160px;
      box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      padding: 10px 0;
      z-index: 999;
      top: 100%;
      left: 0;
    }

    .dropdown-content a {
      color: #333;
      padding: 10px 20px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #f5f5f5;
    }

    .dropdown:hover .dropdown-content,
    .dropdown-content:hover {
      display: block;
    }


    .hero {
      background: linear-gradient(120deg, #A22522, #7e1d1c);
      color: white;
      padding: 60px 20px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .hero h1 {
      font-size: 2.8em;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 1.2em;
      margin-bottom: 30px;
    }

    .section {
      margin: 50px auto;
      max-width: 1000px;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      position: relative;
    }

    .section::before {
      content: '';
      display: block;
      height: 5px;
      background-color: #A22522;
      border-radius: 10px 10px 0 0;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
    }

    .book-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .book {
      background-color: #f5f5f5;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      transition: transform 0.2s ease;
    }

    .book:hover {
      transform: scale(1.03);
    }

    .book img {
      width: 100px;
      height: 140px;
      object-fit: cover;
      margin-bottom: 10px;
      border-radius: 4px;
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

    footer {
      margin-top: 60px;
    }

    .section h2 {
      margin-bottom: 20px;
    }

    .book-link h4,
    .book-link p {
      color: #333;
      transition: color 0.3s ease;
    }

    .book-link:hover h4,
    .book-link:hover p {
      color: #A22522;
    }

    /* Overlay Logout */
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
  </style>
</head>

<body>
  <header>
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 40px;">


      <div class="menu">
        <div class="dropdown">
          <button class="dropdown-button"><i class="fas fa-bars"></i> Menu</button>
          <div class="dropdown-content">
            <a href="catalogo.php">Catalogo</a>
            <?php if (isset($_SESSION['id_operatore'])): ?>
              <a href="area-operatore.php">Area Operatore</a>
            <?php endif; ?>
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
        <?php elseif (isset($_SESSION['id_operatore'])): ?>
          <div style="display: flex; align-items: center; gap: 20px;">
            <span style="font-size: 16px;">Ciao, <?= htmlspecialchars($_SESSION['nome_operatore']) ?> 👋</span>
            <a href="?logout=1<?php if (isset($_GET['id'])) echo '&id=' . intval($_GET['id']); ?>" class="btn">Logout</a>
          </div>
        <?php else: ?>
          <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login</a>
        <?php endif; ?>
      </div>

    </div>
  </header>

  <section class="hero">
    <h1>Benvenuto alla Biblioteca Comunale</h1>
    <p>Un luogo dove cultura, lettura e conoscenza si incontrano</p>
  </section>

  <?php
  $conn = openconnection();
  $sql = "SELECT
  l.codice_libro,
  l.nome AS titolo,
  l.copertina,
  a.nome AS autore,
  COUNT(pl.codice_libro) AS numero_prestiti
  FROM prestiti_libri pl
  JOIN libri l ON l.codice_libro = pl.codice_libro
  JOIN autori a ON l.autori_id_autori = a.id_autori
  GROUP BY l.codice_libro, l.nome, l.copertina, a.nome
  ORDER BY numero_prestiti DESC
  LIMIT 4";

  $result = $conn->query($sql);
  ?>

  <div class="section">
    <h2>📚 Libri più popolari</h2>
    <div class="book-list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <a href="libro.php?id=<?= $row['codice_libro'] ?>" class="book-link">
          <div class="book">
            <img src="<?= htmlspecialchars($row['copertina'] ?: 'https://via.placeholder.com/100x140?text=Nessuna+immagine') ?>" alt="<?= htmlspecialchars($row['titolo']) ?>">
            <h4><?= htmlspecialchars($row['titolo']) ?></h4>
            <p><?= htmlspecialchars($row['autore']) ?></p>
          </div>
        </a>
      <?php endwhile; ?>
    </div>
  </div>

  <?php closeconnection($conn); ?>

  <main>
    <div class="section">
      <h2>📖 Chi siamo</h2>
      <p>La Biblioteca Comunale è il cuore culturale della nostra città. Ogni giorno accogliamo studenti, lettori e cittadini curiosi offrendo spazi di studio, libri, eventi e supporto digitale.</p>
    </div>

    <div class="section">
      <h2>🕒 Orari di apertura</h2>
      <p><strong>Lunedì - Venerdì:</strong> 9:00 - 19:00</p>
      <p><strong>Sabato:</strong> 9:00 - 13:00</p>
      <p><strong>Domenica:</strong> Chiuso</p>
    </div>

    <div class="section">
      <h2>📍 Contatti</h2>
      <p><strong>Indirizzo:</strong> Via della Cultura, 123 - Città</p>
      <p><strong>Telefono:</strong> 0123 456789</p>
      <p><strong>Email:</strong> info@biblioteca.it</p>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 Biblioteca Comunale. Tutti i diritti riservati.</p>
  </footer>

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
