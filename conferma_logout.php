<?php
session_start();

if (isset($_GET['logout_confirm']) && $_GET['logout_confirm'] == '1') {
    ?>
    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8" />
        <title>Conferma Logout</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: rgba(0,0,0,0.5);
                margin: 0;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .confirm-box {
                background: white;
                padding: 30px;
                border-radius: 10px;
                text-align: center;
                box-shadow: 0 0 15px rgba(0,0,0,0.3);
            }
            button {
                margin: 10px;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }
            .yes-btn { background-color: #A22522; color: white; }
            .no-btn { background-color: #ccc; }
        </style>
    </head>
    <body>
        <div class="confirm-box">
            <p>Sei sicuro di voler effettuare il logout?</p>
            <form method="POST" action="logout.php" style="display:inline;">
                <button type="submit" class="yes-btn">Si</button>
            </form>
            <form method="GET" action="home.php" style="display:inline;">
                <button type="submit" class="no-btn">No</button>
            </form>
        </div>
    </body>
    </html>
    <?php
} else {
  header("Location: home.php");
}
?>
