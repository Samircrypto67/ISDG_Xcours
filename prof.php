<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'professeur') {
    header("Location: login.php");
    exit;
}
?>
<?php include("Includes/navbar.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Espace Professeur</title>
  <style>
    body {
      background-color: #f0f0f0;
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 50px;
      position: relative;
    }
    h2 {
      color: #ff6600;
      font-size: 60px;
      font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }
    a.btn-custom {
      margin: 15px;
      padding: 10px 25px;
      background-color: #0077cc;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      display: inline-block;
    }
    a.btn-custom:hover {
      background-color: #005fa3;
    }
    a.logout {
      background-color: gray !important;
    }
    img.fullscreen {
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      object-fit: cover;
      z-index: -1;
      filter: brightness(0.4);
    }
  </style>
</head>
<body>
  <img src="image/images/th (3).jpeg" alt="Fond ISDG" class="fullscreen">
  <h2>Bienvenue Professeur</h2>
  <a href="logout.php" class="btn-custom logout">Déconnexion</a>

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
