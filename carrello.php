<?php
session_start();
date_default_timezone_set('Europe/Rome');

require_once './configurazione.php';
require_once './database.php';

$conn = openconnection();
$ora = time();
$carrello_attivo = [];

// Sblocca libri scaduti
foreach ($_SESSION['carrello'] ?? [] as $item) {
    if ($item['bloccato_fino'] <= $ora) {
        $stmt = $conn->prepare("UPDATE collocati SET disponibilita = 1 WHERE libri_codice_libro = ?");
        $stmt->bind_param("i", $item['id']);
        $stmt->execute();
    }
}

// Mantieni solo quelli validi
$_SESSION['carrello'] = array_filter($_SESSION['carrello'] ?? [], fn($item) => $item['bloccato_fino'] > $ora);
$carrello_attivo = $_SESSION['carrello'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <title>Il tuo Carrello - Biblioteca Comunale</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="style.css"/>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
    }
    .btn {
  background-color: #A22522;
  color: white;
  padding: 10px 18px;
  border-radius: 20px;
  text-decoration: none;
  font-size: 15px;
  font-weight: bold;
  transition: background-color 0.2s ease;
}

.btn:hover {
  background-color: #7e1b1a;
}


    .section {
      max-width: 1000px;
      margin: 50px auto;
      background: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .section h2 {
      font-size: 26px;
      margin-bottom: 20px;
      border-left: 6px solid #A22522;
      padding-left: 15px;
      color: #A22522;
    }

    .book-cart {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .book-item {
      display: flex;
      background-color: #f5f5f5;
      border-radius: 10px;
      padding: 15px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .book-item img {
      width: 100px;
      height: 140px;
      object-fit: cover;
      border-radius: 5px;
      margin-right: 15px;
    }

    .book-details {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .book-details h3 {
      margin: 0 0 10px;
      color: #333;
    }

    .book-details p {
      margin: 5px 0;
      font-size: 14px;
      color: #666;
    }

    .empty-message {
      text-align: center;
      padding: 40px 0;
      font-size: 18px;
      color: #555;
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
<body>
<div style="text-align: center; margin-bottom: 40px;">

<div class="section">
  <div class="section">

    <!-- Pulsante in alto -->
    <div style="text-align: left; margin-bottom: 15px;">
      <a href="catalogo.php" class="btn">← Continua i tuoi acquisti</a>
    </div>

    <!-- Titolo -->
    <h2 style="text-align: left;">🛒 Il tuo Carrello</h2>

    <!-- Contenuto carrello -->
    <?php if (empty($carrello_attivo)): ?>
      <p class="empty-message">Il tuo carrello è vuoto.</p>
    <?php else: ?>
      <div class="book-cart">
        <?php foreach ($carrello_attivo as $item): ?>
          <?php
            $stmt = $conn->prepare("SELECT nome, edizione, costo_prestito, copertina FROM libri WHERE codice_libro = ?");
            $stmt->bind_param("i", $item['id']);
            $stmt->execute();
            $libro = $stmt->get_result()->fetch_assoc();
            $copertina = $libro['copertina'] ?: 'https://via.placeholder.com/100x140?text=Nessuna+immagine';
          ?>
          <div class="book-item">
            <img src="<?= htmlspecialchars($copertina) ?>" alt="Copertina libro">
            <div class="book-details">
              <h3><?= htmlspecialchars($libro['nome']) ?></h3>
              <p>Edizione: <?= htmlspecialchars($libro['edizione']) ?></p>
              <p>Prezzo prestito: €<?= number_format($libro['costo_prestito'], 2, ',', '.') ?></p>
              <p><small>Riservato fino alle <strong><?= date('H:i:s', $item['bloccato_fino']) ?></strong></small></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

<div style="text-align: right; margin-top: 30px;">
  <?php
    $totale = 0;
    foreach ($carrello_attivo as $item) {
        $stmt = $conn->prepare("SELECT costo_prestito FROM libri WHERE codice_libro = ?");
        $stmt->bind_param("i", $item['id']);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $totale += floatval($res['costo_prestito']);
    }
  ?>
  <p style="font-size: 18px; font-weight: bold; margin-bottom: 15px;">
    Totale da pagare: €<?= number_format($totale, 2, ',', '.') ?>
  </p>
  <a href="checkout.php" class="btn">Check-out →</a>
</div>

    <?php endif; ?>

  </div>

  </div>
</div>

</body>
</html>

<?php closeconnection($conn); ?>
