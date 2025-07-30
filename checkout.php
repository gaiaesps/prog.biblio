<?php
session_start();
require_once './configurazione.php';
require_once './database.php';

$ids = array_column($_SESSION['carrello'] ?? [], 'id');
if (empty($ids)) {
    echo "<p>Il carrello è vuoto. <a href='catalogo.php'>Torna al catalogo</a></p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Pagamento</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial; background: #f9f9f9; margin: 0; }
    .checkout-container { max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .form-section label { display: block; margin-top: 15px; font-weight: bold; }
    .form-section input, .form-section select { width: 100%; padding: 10px; font-size: 14px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
    .checkout-button { margin-top: 30px; width: 100%; padding: 12px; background: #A22522; color: white; border: none; border-radius: 30px; font-size: 16px; cursor: pointer; }
    .checkout-button:hover { background: #7e1d1c; }
    .back-link { display: inline-block; margin-bottom: 20px; color: #A22522; text-decoration: none; font-weight: bold; }
  </style>
</head>
<body>
  <div class="checkout-container">
    <a href="carrello.php" class="back-link">← Torna al carrello</a>
    <h2>Inserisci i tuoi dati per il pagamento</h2>

    <form class="form-section" method="post" action="conferma_pagamento.php">
      <label for="nome">Nome completo</label>
      <input type="text" name="nome" id="nome" required>

      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>

      <label for="metodo">Metodo di pagamento</label>
      <select name="metodo" id="metodo" required>
        <option value="">-- Seleziona --</option>
        <option value="carta">Carta di credito</option>
        <option value="paypal">PayPal</option>
        <option value="bancomat">Bancomat</option>
      </select>

      <?php foreach ($ids as $id): ?>
        <input type="hidden" name="libri[]" value="<?= $id ?>">
      <?php endforeach; ?>

      <button type="submit" class="checkout-button">Conferma pagamento</button>
    </form>
  </div>
</body>
</html>
