<?php
session_start();
require_once 'db.php';

$erreur = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    if (!empty($email) && !empty($mot_de_passe)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        var_dump($user);
       if ($user) {
    var_dump($mot_de_passe);
    var_dump($user['mot_de_passe']);
    var_dump(password_verify($mot_de_passe, $user['mot_de_passe']));

    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // mot de passe OK
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'professeur') {
            header("Location: prof.php");
        } else {
            header("Location: etudiant.php");
        }
        exit;
    } else {
        $erreur = "Mot de passe incorrect !";
    }
}
else {
            $erreur = "Utilisateur non trouvé.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="login.css" rel="stylesheet">
    <title>Connexion</title>
 
</head>
    <body>
        <div class="logo-container">LIL Kicht Inc.</div>
    <div class="container">
        <h1>ISDG</h1>
        <h2>Connexion</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <?php if ($erreur): ?>
            <p class="error"><?php echo htmlspecialchars($erreur); ?></p>
        <?php endif; ?>
        <div class="link">
            Pas encore de compte ? <a href="inscription.php">Créer un compte</a>
        </div>
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