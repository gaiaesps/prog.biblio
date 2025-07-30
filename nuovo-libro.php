<?php
require_once('configurazione.php');
require_once('database.php');
$conn=openconnection();

// Recupera autori dal DB per il menu a tendina
$autori = $conn->query("SELECT id_autori, nome FROM autori");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome            = $_POST['nome'];
    $genere          = $_POST['genere'];
    $anno            = $_POST['anno_pubblicazione'];
    $copertina       = $_POST['copertina'];
    $edizione        = $_POST['edizione'];
    $codice_autore   = $_POST['id_autori'];
    $costo_prestito  = $_POST['costo_prestito'];

    $stmt = $conn->prepare("
        INSERT INTO libri
        (nome, genere, anno, copertina,edizione, autori_id_autori, costo_prestito)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssissii", $nome, $genere, $anno, $copertina, $edizione, $codice_autore, $costo_prestito);
    $stmt->execute();
    $codice_libro = $stmt->insert_id;
    $posizione = $_POST['posizione'];
    $disponibilita = 1;
    $bloccato_fino = null;

    // Recupera id_settore in base al genere
    $stmt_settore = $conn->prepare("SELECT id_settore FROM settori WHERE genere = ?");
    $stmt_settore->bind_param("s", $genere);
    $stmt_settore->execute();
    $stmt_settore->bind_result($settore);
    $stmt_settore->fetch();
    $stmt_settore->close();

    // Inserisci in collocati
    $stmt_collocati = $conn->prepare("
        INSERT INTO collocati (posizione, disponibilita, settori_id_settore, libri_codice_libro, bloccato_fino)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt_collocati->bind_param("siiss", $posizione, $disponibilita, $settore, $codice_libro, $bloccato_fino);
    $stmt_collocati->execute();
    $stmt_collocati->close();
    $success = true;
    header("Location: home.php"); // oppure la tua home, tipo "home.php"
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Nuovo Libro</title>
    <style>
        body { font-family: Arial; padding: 30px; background-color: #f5f5f5; }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #A22522;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background-color: #8d1e1c; }
        .success { color: green; text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<h1 style="text-align:center;">📘 Aggiungi un Nuovo Libro</h1>

<form method="post">
    <label>Titolo:</label>
    <input type="text" name="nome" required>

    <label>Genere:</label>
<select name="genere">
  <option value="">-- Seleziona un genere --</option>
  <option value="Romanzo">Romanzo</option>
  <option value="Romanzo breve">Romanzo breve</option>
  <option value="Saggio">Saggio</option>
  <option value="Filosofia">Filosofia</option>
  <option value="Fantastico">Fantastico</option>
  <option value="Fantascienza">Fantascienza</option>
  <option value="Distopia">Distopia</option>
  <option value="Satira">Satira</option>
  <option value="Giallo">Giallo</option>
  <option value="Giallo storico">Giallo storico</option>
  <option value="Storico">Storico</option>
  <option value="Narrativa">Narrativa</option>
  <option value="Narrativa contemporanea">Narrativa contemporanea</option>
  <option value="Realismo Magico">Realismo Magico</option>
  <option value="Racconti">Racconti</option>
  <option value="Biografia">Biografia</option>
  <option value="Autobiografia">Autobiografia</option>
  <option value="Romantico">Romantico</option>
  <option value="Poetico">Poetico</option>
  <option value="Altro">Altro</option>
</select>


    <label>Anno di pubblicazione:</label>
    <input type="number" name="anno_pubblicazione">

    <label>Edizione:</label>
    <input type="text" name="edizione" placeholder="Es. Prima, Seconda">

    <label>URL Copertina:</label>
    <input type="text" name="copertina">

    <label>Autore:</label>
    <select name="id_autori" required>
        <option value="">-- Seleziona un autore --</option>
        <?php while ($autore = $autori->fetch_assoc()): ?>
            <option value="<?= $autore['id_autori'] ?>">
                <?= htmlspecialchars($autore['nome']) ?>
            </option>
        <?php endwhile; ?>
    </select>
    <label>Posizione (scaffale, GEN.##):</label>
    <input type="text" name="posizione" required>
    <label>Costo</label>
    <input type="text" name="costo_prestito" required>

    <button type="submit">➕ Aggiungi Libro</button>
</form>

</body>
</html>
