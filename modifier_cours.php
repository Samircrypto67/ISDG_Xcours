<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professeur') {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

// Récupérer la liste des cours pour le select
$stmt = $pdo->query("SELECT id, nom, jour, heure FROM cours ORDER BY jour, heure");
$cours_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $jour = $_POST['jour'];
    $heure = $_POST['heure'];

    if ($id && $nom && $jour && $heure) {
        $stmt = $pdo->prepare("UPDATE cours SET nom = ?, jour = ?, heure = ? WHERE id = ?");
        if ($stmt->execute([$nom, $jour, $heure, $id])) {
            $success = "Cours modifié avec succès.";
            // Mettre à jour la liste pour afficher les changements
            $stmt = $pdo->query("SELECT id, nom, jour, heure FROM cours ORDER BY jour, heure");
            $cours_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = "Erreur lors de la modification.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modifier un cours</title>
  <link href="modifier_cours.css" rel="stylesheet" />

</head>
<body>
  <img src="image/images/ISDG.jpeg" alt="fond" class="fullscreen" />
  
  <h2>Modifier un cours</h2>

  <?php if ($success): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
  <?php elseif ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="POST">
    <select name="id" required>
      <option value="">-- Sélectionner un cours --</option>
      <?php foreach ($cours_list as $cours): ?>
        <option value="<?= $cours['id'] ?>">
          <?= htmlspecialchars($cours['nom']) . " - " . htmlspecialchars($cours['jour']) . " à " . htmlspecialchars($cours['heure']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <input type="text" name="nom" placeholder="Nouveau nom du cours" required />
    <select name="jour" required>
      <option value="">-- Nouveau jour --</option>
      <option>Lundi</option><option>Mardi</option><option>Mercredi</option>
      <option>Jeudi</option><option>Vendredi</option>
    </select>
    <input type="time" name="heure" required />
    <button type="submit">Modifier</button>
  </form>
  <?php include 'Includes/retour_prof.php'; ?>
  <script>
    document.body.style.opacity = 0;
    window.onload = () => {
      document.body.style.transition = 'opacity 0.5s';
      document.body.style.opacity = 1;
    };
    document.querySelectorAll('a').forEach(lien => {
      lien.addEventListener('click', function(e) {
        e.preventDefault();
        const href = this.getAttribute('href');
        document.body.style.opacity = 0;
        setTimeout(() => window.location.href = href, 500);
      });
    });
  </script>
</body>
</html>