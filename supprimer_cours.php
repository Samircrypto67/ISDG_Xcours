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

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM cours WHERE id = ?");
        if ($stmt->execute([$id])) {
            $success = "Cours supprimé avec succès.";
            // Mettre à jour la liste
            $stmt = $pdo->query("SELECT id, nom, jour, heure FROM cours ORDER BY jour, heure");
            $cours_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = "Erreur lors de la suppression.";
        }
    } else {
        $error = "Veuillez sélectionner un cours.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Supprimer un cours</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: rgba(255, 255, 255, 0.95);
      position: relative;
    }
    h2 {
      color: #0077cc;
      text-align: center;
    }
    form {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      max-width: 400px;
      margin: 30px auto;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    select, button {
      margin: 10px 0;
      padding: 10px;
      width: 100%;
    }
    button {
      background-color: #ff6600;
      color: white;
      border: none;
    }
    .success {
      color: green;
      text-align: center;
      font-weight: bold;
    }
    .error {
      color: red;
      text-align: center;
      font-weight: bold;
    }
    img.fullscreen {
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      object-fit: cover;
      opacity: 0.1;
      z-index: -1;
    }
  </style>
</head>
<body>
  <img src="image/images/ISDG.jpeg" alt="fond" class="fullscreen" />
  
  <h2>Supprimer un cours</h2>

  <?php if ($success): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
  <?php elseif ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
    <select name="id" required>
      <option value="">-- Sélectionner un cours --</option>
      <?php foreach ($cours_list as $cours): ?>
        <option value="<?= $cours['id'] ?>">
          <?= htmlspecialchars($cours['nom']) . " - " . htmlspecialchars($cours['jour']) . " à " . htmlspecialchars($cours['heure']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Supprimer</button>
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