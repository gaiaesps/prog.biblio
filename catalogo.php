<?php
// Collegamento al database
$host = "localhost";
$user = "root";
$pass = "root";
$db = "sakila"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "
SELECT 
  libri.nome AS titolo,
  libri.copertina,
  autori.nome AS autore,
  collocati.disponibilita as disponibilita
FROM libri
JOIN autori ON libri.Autori_idAutori = autori.idAutori
JOIN collocati ON collocati.Libri_CodiceLibro = libri.CodiceLibro
";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <title>Catalogo Libri</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .catalog-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
    .filter-bar { margin-bottom: 30px; text-align: right; }
    .filter-bar select { padding: 8px 12px; font-size: 15px; border-radius: 6px; border: 1px solid #ccc; }
    .book-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; }
    .book-card { background-color: white; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center; transition: transform 0.2s ease; }
    .book-card:hover { transform: scale(1.02); }
    .book-card img { width: 100%; height: 220px; object-fit: cover; }
    .book-info { padding: 15px; }
    .book-info h4 { font-size: 16px; margin: 10px 0 5px; }
    .book-info p { margin: 0; font-size: 14px; color: #555; }
    .book-unavailable { opacity: 0.5; position: relative; }
    .book-unavailable::after { content: "IN PRESTITO"; position: absolute; top: 10px; left: 10px; background-color: #A22522; color: white; padding: 4px 8px; font-size: 12px; border-radius: 5px; }
  </style>
</head>
<body>

  <header>
    <div class="container">
      <h1 style="color: white;">Catalogo Libri</h1>
      <div class="auth-buttons">
        <a href="home.php" class="btn">Home</a>
      </div>
    </div>
  </header>

  <main class="catalog-container">

    <div class="filter-bar">
      <label for="filter">Filtra per disponibilità:</label>
      <select id="filter" onchange="filterBooks()">
        <option value="all">Tutti</option>
        <option value="available">Disponibili</option>
        <option value="unavailable">In prestito</option>
      </select>
    </div>

    <div class="book-grid" id="bookGrid">
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $class = $row["disponibilita"] ? "available" : "unavailable book-unavailable";
              echo '<div class="book-card ' . $class . '">';
              echo '<img src="' . htmlspecialchars($row["copertina"]) . '" alt="' . htmlspecialchars($row["titolo"]) . '">';
              echo '<div class="book-info">';
              echo '<h4>' . htmlspecialchars($row["titolo"]) . '</h4>';
              echo '<p>' . htmlspecialchars($row["autore"]) . '</p>';
              echo '</div></div>';
          }
      } else {
          echo "<p>Nessun libro trovato nel database.</p>";
      }
      ?>
    </div>

  </main>

  <footer>
    <p>&copy; 2025 Biblioteca Comunale</p>
  </footer>

  <script>
    function filterBooks() {
      const filter = document.getElementById("filter").value;
      const books = document.querySelectorAll(".book-card");

      books.forEach(book => {
        if (filter === "all") {
          book.style.display = "block";
        } else if (filter === "available" && book.classList.contains("available")) {
          book.style.display = "block";
        } else if (filter === "unavailable" && book.classList.contains("unavailable")) {
          book.style.display = "block";
        } else {
          book.style.display = "none";
        }
      });
    }
  </script>

</body>
</html>

<?php
$conn->close();
?>