<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professeur') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Professeur</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #ff6600;
        }
        a {
            display: inline-block;
            margin: 15px;
            padding: 10px 20px;
            background-color: #0077cc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #005fa3;
        }
    </style>
</head>

<body>
   <h1>Bienvenue Professeur</h1>
    <a href="ajouter_cours.php">Ajouter un cours</a>
    <a href="modifier_cours.php">Modifier un cours</a>
    <a href="supprimer_cours.php">Supprimer un cours</a>
    <br><br>
    <a href="logout.php" style="background-color: gray;">Déconnexion</a>
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
