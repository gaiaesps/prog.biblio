<?php
require_once('configurazione.php');
require_once('database.php');
$conn=openconnection();
// Se è stato cliccato "Restituisci"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codice_libro'])) {
    $codice_libro = $_POST['codice_libro'];

    // 1. aggiorna disponibilità a TRUE
    $updateLibro = $conn->prepare("UPDATE collocati SET disponibilita = TRUE WHERE libri_codice_libro = ?");
    $updateLibro->bind_param("i", $codice_libro);
    $updateLibro->execute();

    // 2. aggiorna data_restituzione a oggi per tutti i prestiti attivi di quel libro
    $updatePrestito = $conn->prepare("
        UPDATE prestiti
        JOIN prestiti_libri ON prestiti.id_prestito = prestiti_libri.id_prestito
        SET data_restituzione = CURDATE()
        WHERE prestiti_libri.codice_libro = ? AND data_restituzione IS NULL
    ");
    $updatePrestito->bind_param("i", $codice_libro);
    $updatePrestito->execute();
}

// Query per visualizzare i libri attualmente in prestito
$sql = "
SELECT
    prestiti.id_prestito,
    clienti.nome AS nome_cliente,
    libri.nome AS titolo,
    libri.codice_libro
FROM prestiti
JOIN clienti ON prestiti.clienti_id_cliente = clienti.id_cliente
JOIN prestiti_libri ON prestiti.id_prestito = prestiti_libri.id_prestito
JOIN libri ON prestiti_libri.codice_libro = libri.codice_libro
WHERE prestiti.data_restituzione IS NULL
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Area Operatore</title>
    <style>
        body { font-family: Arial; padding: 30px; background-color: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
        th { background-color: #A22522; color: white; }
        form { margin: 0; }
        .btn { background-color: #2A2B2E; color: white; border: none; padding: 6px 10px; cursor: pointer; }
        .btn:hover { background-color: #444; }
    </style>
</head>
<body>

<h1>Area Operatore - Libri in Prestito</h1>
<a href="home.php" class="btn" style="margin-top: 30px; display: inline-block;">Vai alla home</a>
<?php if ($result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>Titolo</th>
            <th>Cliente</th>
            <th>Codice libro</th>
            <th>Azione</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['titolo']) ?></td>
            <td><?= htmlspecialchars($row['nome_cliente']) ?></td>
            <td><?= $row['codice_libro'] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="codice_libro" value="<?= $row['codice_libro'] ?>">
                    <button class="btn" type="submit">Restituisci</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>Nessun libro attualmente in prestito.</p>
<?php endif; ?>

<a href="nuovo-libro.php" class="btn" style="margin-top: 30px; display: inline-block;">➕ Aggiungi nuovo libro</a>

</body>
</html>
