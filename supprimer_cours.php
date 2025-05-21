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
    $stmt = $pdo->prepare("DELETE FROM cours WHERE id = ?");
    if ($stmt->execute([$id])) {
        $success = "Cours supprimé avec succès.";
        $cours = $pdo->query("SELECT * FROM cours")->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer Cours</title>
    <style>
        body {
            background-color: #fdf5f0;
            font-family: Arial;
            padding: 40px;
        }
        h2 {
            color: #cc3300;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background-color: #cc0000;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <h2>Supprimer un cours</h2>
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
        <select name="id" required>
            <option value="">-- Choisir un cours --</option>
            <?php foreach ($cours as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['nom'] ?> - <?= $c['jour'] ?> à <?= $c['heure'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Supprimer</button>
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
