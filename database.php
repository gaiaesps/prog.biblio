<?php
function openconnection(){
  global $cfg;
  $conn = new mysqli($cfg['dbhost'], $cfg['dbuser'], $cfg['dbpwd'], $cfg['dbname']);
  //La freccia (->) in PHP viene utilizzata per accedere a metodi e proprietà di un oggetto.
  if ($conn->connect_error) {
      //In PHP, die() è una funzione che viene utilizzata per terminare immediatamente
      //l'esecuzione di uno script e
      //visualizzare un messaggio di errore specificato dall'utente.
      die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

function closeconnection($myconnection){
  $myconnection->close();
}
?>
