<?php
require_once 'db.php';
$erreur = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $role = $_POST['role'] ?? 'etudiant'; // valeur par défaut

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($mot_de_passe)) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $hashed_password, $role]);
            $success = true;
        } catch (PDOException $e) {
            $erreur = "Erreur lors de l'inscription : " . $e->getMessage();
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
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #111, #222);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      background-color: #2f2f2f;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
      width: 400px;
      text-align: center;
    }
    input, select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 6px;
      border: none;
      background-color: #444;
      color: white;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #FFA500;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    .success-animation {
      font-size: 20px;
      color: #00ff99;
      animation: fadeInOut 3s ease-in-out forwards;
    }
    @keyframes fadeInOut {
      0% { opacity: 0; transform: scale(0.9); }
      20% { opacity: 1; transform: scale(1.05); }
      80% { opacity: 1; transform: scale(1); }
      100% { opacity: 0; transform: scale(0.9); }
    }
    .error {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Créer un compte</h1>

    <?php if ($success): ?>
      <p class="success-animation">✅ Inscription réussie ! Redirection en cours...</p>
      <script>
        setTimeout(() => {
          window.location.href = 'login.php';
        }, 3000); // redirection après 3 secondes
      </script>
    <?php else: ?>
      <form action="Inscription.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <input type="date" name="date_naissance" class="form-control mb-2" required>
        <input type="text" name="pays" placeholder="Pays d'origine" class="form-control mb-2" required>
        <input type="text" name="formation" placeholder="Formation" class="form-control mb-2" required>
        <label for="photo">Photo de l'étudiant: </label>
        <input type="file" name="photo" id="photo" required>
        <select name="role" required>
          <option value="etudiant">Étudiant</option>
        </select>
        <button type="submit">S'inscrire</button>
      </form>
      <?php if ($erreur): ?>
        <p class="error"><?php echo htmlspecialchars($erreur); ?></p>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</body>
</html>