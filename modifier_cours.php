<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professeur') {
    header('Location: login.php');
    exit;
}

$success = '';
$cours = $pdo->query("SELECT * FROM cours")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $jour = $_POST['jour'];
    $heure = $_POST['heure'];

    $stmt = $pdo->prepare("UPDATE cours SET nom = ?, jour = ?, heure = ? WHERE id = ?");
    if ($stmt->execute([$nom, $jour, $heure, $id])) {
        $success = "Cours modifié avec succès.";
        $cours = $pdo->query("SELECT * FROM cours")->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Cours</title>
    <style>
        body {
            background-color: #f9f9f9;
            font-family: Arial;
            padding: 40px;
        }
        h2 {
            color: #0077cc;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 320px;
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
    <h2>Modifier un cours</h2>
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
        <select name="id" required>
            <option value="">-- Choisir un cours --</option>
            <?php foreach ($cours as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['nom'] ?> - <?= $c['jour'] ?> à <?= $c['heure'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="nom" placeholder="Nouveau nom" required>
        <select name="jour" required>
            <option value="">-- Jour --</option>
            <option>Lundi</option><option>Mardi</option><option>Mercredi</option>
            <option>Jeudi</option><option>Vendredi</option>
        </select>
        <input type="time" name="heure" required>
        <button type="submit">Modifier</button>
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
</body>
</html>
