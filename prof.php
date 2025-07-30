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
  <link href="prof.css" rel="stylesheet">
  <title>Espace Professeur</title>

</head>

<body>
  <img src="image/images/th.png" alt="Fond ISDG" class="fullscreen">
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