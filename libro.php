<?php
require_once './configurazione.php';
require_once './database.php';
session_start();
$session_timeout = 7200;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['conferma_logout'])) {
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id);
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
            top: 110%;
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

            .dropdown:hover .dropdown-content {
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

            /* Sezioni con barra colorata */
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

            .dropdown-button {
              padding: 10px 20px;
              border-radius: 25px;
            }
          </style>
    </head>
    <?php include 'header.php'; ?>

    <body>
      <?php
        $conn=openconnection();
        $titoloQuery = "SELECT nome FROM libri WHERE codice_libro = ?";
        $stmt = $conn->prepare($titoloQuery);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $titoloResult = $stmt->get_result();
        $titoloRow = $titoloResult->fetch_assoc();
        $titolo = $titoloRow['nome'] ?? null;
        $edizioni = [];
        $libro = null;
        if ($titolo) {
          $mainQuery = "
            SELECT
              l.codice_libro,
              l.nome AS titolo,
              l.copertina,
              l.edizione,
              l.costo_prestito,
              l.genere,
              a.nome AS autore,
              a.nazionalita,
              c.disponibilita
            FROM libri l
            JOIN autori a ON l.autori_id_autori = a.id_autori
            JOIN collocati c ON l.codice_libro = c.libri_codice_libro
            WHERE l.nome = ?";
          $stmt = $conn->prepare($mainQuery);
          $stmt->bind_param("s", $titolo);
          $stmt->execute();
          $result = $stmt->get_result();
          $edizioni = $result->fetch_all(MYSQLI_ASSOC);
          $libro = count($edizioni) > 0 ? $edizioni[0] : null;
        }
        closeconnection($conn);
        ?>
        <?php if ($libro): ?>
  <div class="section" style="max-width: 1000px; margin: 40px auto; display: flex; gap: 40px; align-items: flex-start;">


    <div style="flex: 1; text-align: center;">
      <img src="<?= htmlspecialchars($libro['copertina']) ?>" alt="Copertina" style="width:200px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
      <h2 style="margin-top: 20px; color: #A22522;"><?= htmlspecialchars($libro['titolo']) ?></h2>
      <p><strong>Nazionalità:</strong> <?= htmlspecialchars($libro['nazionalita']) ?></p>
      <p><strong>Genere:</strong> <?= htmlspecialchars($libro['genere']) ?></p>
    </div>

    <div style="flex: 2;">
      <h3>Edizioni disponibili:</h3>
      <?php foreach ($edizioni as $edizione): ?>
        <div style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; margin-bottom: 15px; background-color: #f9f9f9;">
          <p><strong>Edizione :
            <?= htmlspecialchars($edizione['edizione']) ?></strong></p>
          <p><strong>Costo:</strong> €<?= number_format($edizione['costo_prestito'], 2) ?></p>
          <p><strong>Disponibilità:</strong>
            <?php if ($edizione['disponibilita']): ?>
              <span style="color: green;">✓ Disponibile</span>
              <form action="aggiungi_carrello.php" method="get" style="margin-top: 10px;">
                <input type="hidden" name="id" value="<?= htmlspecialchars($edizione['codice_libro']) ?>">
                <button type="submit" style="padding: 8px 16px; background-color: #A22522; color: white; border: none; border-radius: 20px; cursor: pointer;">
                  🛒 Aggiungi al carrello
                </button>
              </form>
            <?php else: ?>
              <span style="color: red;">✖ In prestito</span>
            <?php endif; ?>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div style="text-align: center; margin-bottom: 40px;">
    <a href="home.php" class="btn" style="background-color: #2A2B2E; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none;">← Vai alla Home</a>
  </div>
  <?php else: ?>
    <div class="section"><p>Libro non trovato.</p></div>
  <?php endif; ?>
  <?php if (isset($_GET['logout'])): ?>
  <div class="overlay" style="
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex; align-items: center; justify-content: center;
    z-index: 10000;">
    <div class="confirm-box" style="
      background: white; padding: 30px; border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.4);
      text-align: center; max-width: 400px;">
      <h3>Sei sicuro di voler effettuare il logout?</h3>
      <form method="post" style="display:inline-block; margin:0 10px;">
        <input type="hidden" name="conferma_logout" value="1">
        <button type="submit" style="
          padding: 10px 20px; border-radius: 25px; font-size: 16px;
          border: none; cursor: pointer; background-color: #A22522; color: white;">
          Sì
        </button>
      </form>
      <form method="get" style="display:inline-block; margin:0 10px;">
  <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
  <button type="submit" style="padding: 10px 20px; border-radius: 25px; font-size: 16px;
  border: none; cursor: pointer; background-color: #ccc; color: #333;">No</button>
</form>
    </div>
  </div>
<?php endif; ?>
