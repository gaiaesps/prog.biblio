<?php
session_start();
require_once('configurazione.php');
require_once('database.php');
$conn=openconnection();

if (!isset($_SESSION['id_cliente'])) {
    echo "Devi effettuare il login per accedere a quest'area.";
    exit;
}

$idUtente = $_SESSION['id_cliente'];

$sql = "
SELECT
    libri.nome AS titolo,
    libri.copertina,
    prestiti.data_inizio,
    prestiti.data_fine,
    DATEDIFF(prestiti.data_fine, CURDATE()) AS giorni_mancanti
FROM prestiti
JOIN prestiti_libri ON prestiti.id_prestito = prestiti_libri.id_prestito
JOIN libri ON prestiti_libri.codice_libro = libri.codice_libro
WHERE prestiti.clienti_id_cliente = ? AND prestiti.data_restituzione IS NULL
";

$sqlStorico = "
SELECT
    libri.nome AS titolo,
    libri.copertina,
    prestiti.data_inizio,
    prestiti.data_fine,
    prestiti.data_restituzione
FROM prestiti
JOIN prestiti_libri ON prestiti.id_prestito = prestiti_libri.id_prestito
JOIN libri ON prestiti_libri.codice_libro = libri.codice_libro
WHERE prestiti.clienti_id_cliente = ?
ORDER BY prestiti.data_inizio DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUtente);
$stmt->execute();
$result = $stmt->get_result();

$stmtStorico = $conn->prepare($sqlStorico);
$stmtStorico->bind_param("i", $idUtente);
$stmtStorico->execute();
$resultStorico = $stmtStorico->get_result();
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
    <meta charset="UTF-8">
    <title>Area Personale</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f4f4;
        }

        header {
            background-color: #A22522;
            padding: 20px 0;
        }

        header .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        header nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-right: 20px;
        }

        header nav a:last-child {
            margin-right: 0;
        }

        .prestiti-section {
            margin-bottom: 60px;
        }

        .libri-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .libro-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 15px;
            margin: 20px 0;
            max-width: 500px;
            display: flex;
            align-items: center;
            gap: 20px;
            width: 32%;
            box-sizing: border-box;
        }

        .libro-card img {
            height: 120px;
            border-radius: 6px;
        }

        .libro-info {
            text-align: left;
        }

        .libro-info strong {
            font-size: 18px;
            display: block;
            margin-bottom: 6px;
        }

        .ok { color: green; }
        .ritardo { color: red; }

        h2 {
            color: white;
            margin-top: 50px;
        }

        .bg-rosso {
            background-color: #A22522;
            color: black;
            padding: 30px;
            border-radius: 10px;
            margin: 30px auto;
            max-width: 1200px;
        }

        footer {
            background-color: #A22522;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .libro-card {
                width: 100%;
            }

            header .container {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            header nav {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
        }
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

<body>

  <header>
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">


      <nav>
        <a href="catalogo.php" style="color: white; text-decoration: none; font-weight: bold;">Catalogo</a>
      </nav>


      <div class="auth-buttons">
        <div style="display: flex; align-items: center; gap: 20px;">
          <span style="font-size: 16px;">Ciao, <?= htmlspecialchars($_SESSION['nome']) ?> 👋</span>
          <a href="carrello.php" style="display: flex; align-items: center;">
            <img src="carrellosito.png" alt="Carrello" style="width: 60px; height: 60px;">
          </a>
          <a href="<?= $_SERVER['PHP_SELF'] ?>?logout=1&return=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn">Logout</a>
        </div>
      </div>

    </div>
  </header>




    <main>
        <section class="prestiti-section bg-rosso">
            <h2>Prestiti Attivi</h2>

            <?php if ($result->num_rows > 0): ?>
                <div class="libri-container">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="libro-card">
                            <img src="<?= htmlspecialchars($row['copertina']) ?>" alt="Copertina">
                            <div class="libro-info">
                                <strong><?= htmlspecialchars($row['titolo']) ?></strong>
                                Data prestito: <?= $row['data_inizio'] ?><br>
                                Scadenza: <?= $row['data_fine'] ?><br>
                                <?php if ($row['giorni_mancanti'] >= 0): ?>
                                    <span class="ok">Mancano <?= $row['giorni_mancanti'] ?> giorni</span>
                                <?php else: ?>
                                    <span class="ritardo">In ritardo di <?= abs($row['giorni_mancanti']) ?> giorni!</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Non hai prestiti attivi al momento.</p>
            <?php endif; ?>
        </section>

        <section class="storico-section bg-rosso">
            <h2>Storico Prestiti</h2>

            <?php if ($resultStorico->num_rows > 0): ?>
                <div class="libri-container">
                    <?php while ($row = $resultStorico->fetch_assoc()): ?>
                        <div class="libro-card">
                            <img src="<?= htmlspecialchars($row['copertina']) ?>" alt="Copertina">
                            <div class="libro-info">
                                <strong><?= htmlspecialchars($row['titolo']) ?></strong>
                                Data prestito: <?= $row['data_inizio'] ?><br>
                                Scadenza: <?= $row['data_fine'] ?><br>
                                <?php if ($row['data_restituzione']): ?>
                                    Restituito il: <?= $row['data_restituzione'] ?>
                                <?php else: ?>
                                    <span class="ok">(Ancora attivo)</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Non hai ancora effettuato prestiti.</p>
            <?php endif; ?>
        </section>
        <div style="text-align: center; margin-bottom: 40px;">
          <a href="home.php" class="btn" style="background-color: #2A2B2E; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none;">← Vai alla Home</a>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>&copy; 2025 Bibliodb - Tutti i diritti riservati</p>
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
