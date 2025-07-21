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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Ajouter Cours</title>
    <style>
        body {
            background-color: #e6f0ff;
            font-family: Arial;
            padding: 40px;
            color: #333;
        }
        h2 {
            color: #0077cc;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        input, select, button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
        }
        button {
            background-color: #ff6600;
            color: white;
            border: none;
        }
    </style>
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
<?php include("Includes/retour_prof.php"); ?>

</body>
</html>