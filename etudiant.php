<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Étudiant</title>
    <style>
        body {
            background-color: #e6f0fa;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header {
            background: linear-gradient(to right, #FFA500, #1E90FF);
            color: white;
            padding: 20px;
            text-align: center;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .container {
            margin-top: 40px;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px #ccc;
            width: 80%;
            max-width: 800px;
            text-align: center;
        }
        img {
            max-width: 200px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenue sur ISDG - Espace Étudiant</h1>
    </div>

    <div class="container">
        <img src="images/eleve.png" alt="Image Élève">
        <h2>Bonjour étudiant !</h2>
        <p>Vous êtes connecté en tant qu'étudiant. Vous pouvez consulter vos cours et vos devoirs ici.</p>
    </div>
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
