<?php
session_start();
require_once './configurazione.php';
require_once './database.php';

$conn = openconnection();

// Validazione dati
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$metodo = $_POST['metodo'] ?? '';
$libri = $_POST['libri'] ?? [];

$id_cliente = $_SESSION['id_cliente'] ?? null;
if (!$id_cliente) {
    echo "<p>Sessione non valida. Effettua di nuovo il login. <a href='login.php'>Login</a></p>";
    exit;
}

$conn->begin_transaction();

try {
    // 1. Inserisci prestito
    $stmt = $conn->prepare("INSERT INTO prestiti (clienti_id_cliente, data_inizio, data_fine) VALUES (?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 15 DAY))");
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $id_prestito = $conn->insert_id;
    $stmt->close();

    // 2. Inserisci ogni libro nel prestito_libri
    $stmt_prestiti_libri = $conn->prepare("INSERT INTO prestiti_libri (id_prestito, codice_libro) VALUES (?, ?)");
    $stmt_prestiti_libri->bind_param("ii", $id_prestito, $id_libro);

    foreach ($libri as $id_libro) {
        $stmt_prestiti_libri->execute();
    }
    $stmt_prestiti_libri->close();

    // 3. Aggiorna i libri come non disponibili
    $stmt_update = $conn->prepare("UPDATE collocati SET disponibilita = 0, posizione = NULL, bloccato_fino = NULL WHERE libri_codice_libro = ?");
    $stmt_update->bind_param("i", $id_libro);

    foreach ($libri as $id_libro) {
        $stmt_update->execute();
    }
    $stmt_update->close();

    // 4. Svuota il carrello
    $_SESSION['carrello'] = [];

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    echo "<p>Errore durante la registrazione del prestito: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Pagamento Confermato</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial; background: #f2f2f2; }
    .confirmation { max-width: 600px; margin: 60px auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }
    .confirmation h2 { color: #A22522; }
    .confirmation p { font-size: 16px; margin-top: 20px; }
    .btn-home { margin-top: 30px; display: inline-block; padding: 10px 20px; background: #2A2B2E; color: white; border-radius: 25px; text-decoration: none; }
    .btn-home:hover { background: #1f1f22; }
  </style>
</head>
<body>
  <div class="confirmation">
    <h2>✅ Pagamento confermato</h2>
    <p>Grazie, <strong><?= htmlspecialchars($nome) ?></strong>! Il tuo ordine è stato registrato con successo.</p>
    <p>Riceverai una conferma all'indirizzo email <strong><?= htmlspecialchars($email) ?></strong>.</p>
    <a href="catalogo.php" class="btn-home">Torna al catalogo</a>
  </div>
</body>
</html>
