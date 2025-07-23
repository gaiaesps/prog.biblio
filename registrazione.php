<?php
ob_start();
require_once './configurazione.php';
require_once './database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Login Biblioteca</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background-image: url("Immagine WhatsApp 2025-07-23 ore 19.00.58_718a2bba.jpg"); /* oppure un link esterno */
      background-size: cover; /* fa in modo che l'immagine copra tutto lo sfondo */
      background-position: center;
      background-repeat: no-repeat;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.8);
      color: #333;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 400px;
      text-align: center;
      max-height: 90vh;
      padding: 20px 30px;
      resize: none;
      overflow: auto;
      backdrop-filter: blur(8px);
    }

    .login-container img {
      width: 135px;
      margin-bottom: 40px;
      border-radius: 28px;
    }

    .login-container h2 {
      margin-bottom: 30px;
      color: #A22522;
    }

    .form-group {
      margin-bottom: 14px;
      text-align: left;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border-radius: 25px;
      border: 1px solid #ccc;
      font-size: 16px;
      box-sizing: border-box;
    }
    .form-group select {
      padding: 8px 12px;
      font-size: 14px;
      border-radius: 25px;
    }

    .form-group i {
      margin-right: 10px;
      color: #A22522;
    }

    .login-btn {
      background-color: #A22522;
      color: white;
      border: none;
      padding: 12px 30px;
      font-size: 16px;
      border-radius: 25px;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 15px;
    }

    .login-btn:hover {
      background-color: #7e1d1c;
    }

    .links {
      margin-top: 20px;
      font-size: 14px;
    }

    .links a {
      color: #A22522;
      text-decoration: none;
      margin-left: 5px;
    }

    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Registrazione</h2>
    <form method='POST' action=''>
      <div class="form-group">
        <label>
          <i class="fas fa-envelope"></i>
          <input type="text" name="email" placeholder="Email" required>
        </label>
      </div>
      <div class="form-group">
        <label>
          <i class="fas fa-user"></i>
          <input type="text" name="nome" placeholder="Nome e Cognome:" required>
        </label>
      </div>
      <div class="form-group">
        <label>
          <i class="fas fa-phone"></i>
          <input type="text" name="numero_tel" placeholder="Numero di telefono:" required>
        </label>
      </div>
      <div class="form-group">
        <label>
          <i class="fas fa-map-marker-alt"></i>
          <input type="text" name="indirizzo" placeholder="Indirizzo" required>
        </label>
      </div>
      <div class="form-group">
  <label>
    <i class="fas fa-building"></i>
    <select name="tipocliente">
      <option value="Privato">Privato</option>
      <option value="Servizio Pubblico">Pubblico</option>
    </select>
  </label>
</div>

      <div class="form-group">
        <label>
          <i class="fas fa-id-badge"></i>
          <input type="text" name="codiceF" placeholder="Codice Fiscale">
        </label>
      </div>

            <div class="form-group">
              <label>
                <i class="fas fa-id-badge"></i>
                <input type="text" name="PartitaIva" placeholder="Partita Iva">
              </label>
            </div>
      <div class="form-group">
        <label>
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </label>
      </div>
       <button type="submit" class="login-btn">Registrati</button>
     </form>
<?php
  $conn=openconnection();
  if(isset($_POST["nome"],$_POST["email"],$_POST["numero_tel"],$_POST["indirizzo"],$_POST["password"])&&$_SERVER['REQUEST_METHOD']==='POST'){
    $nome=$_POST["nome"];
    $email=$_POST["email"];
    $numerotel=$_POST["numero_tel"];
    $indirizzo=$_POST["indirizzo"];
    $password=$_POST["password"];
    $codicef=$_POST["codiceF"];
    $partitaiva=$_POST["PartitaIva"];
    if($_POST["tipocliente"]==='Privato'&& empty($codicef))
      die("Errore: il codice fiscale è obbligatorio");
    if($_POST["tipocliente"]==='Servizio Pubblico'&& empty($partitaiva))
      die("Errore: il codice fiscale è obbligatorio");
    $sql="INSERT INTO clienti (nome,email,numero_tel,indirizzo,codiceF,PartitaIva,tipocliente,password) VALUES ('$nome', '$email', '$numerotel', '$indirizzo', '$codicef', '$partitaiva', '{$_POST["tipocliente"]}', '$password')";
    if (mysqli_query($conn, $sql)) {
    header("Location: login.php");
    exit;
  }else{
    echo "Errore";
  }
  }
  closeconnection($conn);
?>
</body>
</html>
