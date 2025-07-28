<?php
session_start();
require_once './configurazione.php';
require_once './database.php';

$id_libro = intval($_POST['id']);
$scadenza = time() + 900; // 15 minuti

$conn = openconnection();

// Verifica se il libro è disponibile
$check = $conn->prepare("SELECT disponibilita FROM collocati WHERE libri_codice_libro = ? LIMIT 1");
$check->bind_param("i", $id_libro);
$check->execute();
$res = $check->get_result()->fetch_assoc();
$check->close();

if ($res && $res['disponibilita'] == 1) {
    // Blocca il libro
    $stmt = $conn->prepare("UPDATE collocati SET disponibilita = 0, bloccato_fino = ? WHERE libri_codice_libro = ?");
    $stmt->bind_param("ii", $scadenza, $id_libro);
    $stmt->execute();
    $stmt->close();

    // Aggiungi al carrello in sessione
    $_SESSION['carrello'][] = [
        'id' => $id_libro,
        'bloccato_fino' => $scadenza
    ];
}

closeconnection($conn);
header("Location: carrello.php");
exit();
?>
