<?php
require_once 'db.php';

$erreur = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    if (!empty($email) && !empty($mot_de_passe)) {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existing = $stmt->fetch();

        if ($existing) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, mot_de_passe, role) VALUES (?, ?, 'etudiant')");
            $stmt->execute([$email, $hash]);
            $success = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        }
    } else {
        $erreur = "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Étudiant</title>
</head>
<body>
    <h2>Inscription Étudiant</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br><br>
        <button type="submit">S'inscrire</button>
    </form>

    <?php if ($erreur): ?>
        <p style="color:red;"><?php echo htmlspecialchars($erreur); ?></p>
    <?php elseif ($success): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
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
