<header>
<div class="container" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 40px;">


  <div class="menu">
    <div class="dropdown">
      <button class="dropdown-button"><i class="fas fa-bars"></i> Menu</button>
      <div class="dropdown-content">
        <a href="catalogo.php">Catalogo</a>
        <?php if (isset($_SESSION['id_cliente'])): ?>
          <a href="area-personale.php">Area Personale</a>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <div class="auth-buttons">
    <?php if (isset($_SESSION['id_cliente'])): ?>
      <span style="margin-right: 15px;">Ciao, <?= htmlspecialchars($_SESSION['nome']) ?> 👋</span>
      <a href="?logout=1<?php if (isset($_GET['id'])) echo '&id=' . intval($_GET['id']); ?>" class="btn">Logout</a>
    <?php else: ?>
      <a href="login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Login</a>
    <?php endif; ?>
  </div>

</div>
</header>
