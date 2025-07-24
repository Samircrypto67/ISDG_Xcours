<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professeur') {
    header('Location: login.php');
    exit;
}

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $jour = $_POST['jour'];
    $heure = $_POST['heure'];

    $stmt = $pdo->prepare("INSERT INTO cours (nom, jour, heure) VALUES (?, ?, ?)");
    if ($stmt->execute([$nom, $jour, $heure])) {
        $success = "Cours ajouté avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="ajouter_cours.css" rel="stylesheet">
    <title>Ajouter Cours</title>
    
</head>
<body>
    
    <h2>Ajouter un cours</h2>

    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom du cours" required>
        <select name="jour" required>
            <option value="">-- Jour --</option>
            <option>Lundi</option>
            <option>Mardi</option>
            <option>Mercredi</option>
            <option>Jeudi</option>
            <option>Vendredi</option>
             <option>Samedi</option>
              <option>Dimanche</option>
        </select>
        <input type="time" name="heure" required>
        <button type="submit">Ajouter</button>
    </form>
    <script>
  // Effet d'apparition
  document.body.style.opacity = 0;
  window.onload = () => {
    document.body.style.transition = 'opacity 0.5s';
    document.body.style.opacity = 1;
  };

  // Effet de disparition quand on clique sur un lien
  const liens = document.querySelectorAll('a');
  liens.forEach(lien => {
    lien.addEventListener('click', function(e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      document.body.style.opacity = 0;
      setTimeout(() => {
        window.location.href = href;
      }, 500);
    });
  });
</script>
<hr>
<?php include("Includes/retour_prof.php"); ?>

</body>
</html>