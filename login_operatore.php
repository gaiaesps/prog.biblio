<?php
require_once './configurazione.php';
require_once './database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Login Operatore</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background: linear-gradient(120deg, #A22522, #7e1d1c);
      color: white;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background-color: white;
      color: #333;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 400px;
      text-align: center;
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
      margin-bottom: 20px;
      text-align: left;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border-radius: 25px;
      border: 1px solid #ccc;
      font-size: 16px;
      box-sizing: border-box;
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
    <img src="https://i.postimg.cc/G2XR3NGz/IMG-0832.jpg" alt="Logo Biblioteca">
    <h2>Accesso Operatore</h2>
    <form method='POST' action=''>
      <div class="form-group">
        <label>
          <i class="fas fa-user-shield"></i>
          <input type="text" name="username" placeholder="Username operatore" required>
        </label>
      </div>
      <div class="form-group">
        <label>
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </label>
      </div>
      <button type="submit" class="login-btn">Login</button>
    </form>
    <div class="links">
      <a href="login.php">Sono un cliente</a>
    </div>
    <div class="links">
      <a href="home.php">Home</a>
    </div>
  </div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $conn = openconnection();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM operatori WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $operatore = $res->fetch_assoc();
        if ($password === $operatore['password']) {
            $_SESSION['id_operatore'] = $operatore['id_operatore'];
            $_SESSION['nome_operatore'] = $operatore['nome'];
            header("Location: area-operatore.php");
            exit;
        } else {
            echo "<p style='color:red; text-align:center;'>Password errata.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Operatore non trovato.</p>";
    }

    $stmt->close();
    closeconnection($conn);
}
?>
</body>
</html>
