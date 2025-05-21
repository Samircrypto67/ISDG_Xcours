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
    <title>Connexion</title>
    <style>
        .logo-container {
    margin-top: 50px;
    text-align: center;
    font-size: 48px;
    font-weight: bold;
    color: orange;
    animation: glow 2s infinite alternate ease-in-out;
    text-shadow: 2px 2px 5px blue;
  }

  @keyframes glow {
    from {
      transform: scale(1) rotate(0deg);
      text-shadow: 0 0 10px blue, 0 0 20px gray;
    }
    to {
      transform: scale(1.1) rotate(5deg);
      text-shadow: 0 0 20px orange, 0 0 30px blue;
    }
  }
        body {
            margin: 0;
            background: linear-gradient(135deg, #1e1e2f, #2c2c2c);
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #2f2f2f;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
            text-align: center;
            width: 350px;
        }
        h1 {
            font-size: 40px;
            color: #FFA500; /* Orange */
            margin-bottom: 30px;
        }
        h2 {
            margin-bottom: 25px;
            color: #4e9af1; /* Bleu */
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
            background-color: #444;
            color: white;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #FFA500; /* Orange */
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #e69500;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .link {
            margin-top: 15px;
            font-size: 14px;
        }
        .link a {
            color: #4e9af1;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
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
