<?php
session_start();
require_once 'db.php';
$erreur = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $formation = $_POST['formation'] ?? '';
    $specialite = $_POST['specialite'] ?? '';
    $role = $_POST['role'] ?? 'etudiant';

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($mot_de_passe) && !empty($date_naissance) && !empty($formation) && !empty($specialite)) {

        // Gestion upload photo
        $photoPath = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileName = basename($_FILES['photo']['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExt, $allowed)) {
                $newFileName = uniqid('photo_') . '.' . $fileExt;
                $destPath = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $photoPath = $destPath;
                } else {
                    $erreur = "Erreur lors du déplacement du fichier photo.";
                }
            } else {
                $erreur = "Type de fichier non autorisé. Seules jpg, jpeg, png, gif sont acceptées.";
            }
        } else {
            $erreur = "Erreur lors de l'upload de la photo.";
        }

        if (!$erreur) {
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            try {
                $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, date_naissance, formation, specialite, photo, role) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $email, $hashed_password, $date_naissance, $formation, $specialite, $photoPath, $role]);

                $success = true;
            } catch (PDOException $e) {
                $erreur = "Erreur lors de l'inscription : " . $e->getMessage();
            }
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
  <link href="Inscription.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Créer un compte</h1>

    <?php if ($success): ?>
      <p class="success-animation">✅ Inscription réussie ! Redirection en cours...</p>

      <?php if (!empty($photoPath)): ?>
        <p>Photo de profil :</p>
        <img src="<?php echo htmlspecialchars($photoPath); ?>" alt="Photo de l'étudiant" style="max-width: 200px;">
      <?php endif; ?>

      <script>
        setTimeout(() => {
          window.location.href = 'login.php';
        }, 3000);
      </script>

    <?php else: ?>
      <!-- Formulaire -->
      <form action="Inscription.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>

        <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required> 
        <button type="button" onclick="togglePassword()">VOIR</button>

        <input type="date" name="date_naissance" required>
        <input type="text" name="formation" placeholder="Formation" required>

        <label for="specialite">Choisis ta spécialité :</label>
        <select name="specialite" id="specialite" required>
          <option value="">-- Sélectionne --</option>
          <option value="SIO/SLAM">SLAM</option>
          <option value="SIO/SISR">SISR</option>
          <option value="MCO">MCO</option>
        </select>

        <label for="photo">Photo de l'étudiant: </label>
        <input type="file" name="photo" id="photo" required>

        <select name="role" required>
          <option value="etudiant">Étudiant</option>
        </select>

        <button type="submit">S'inscrire</button>
      </form>

      <!-- Affichage des erreurs -->
      <?php if ($erreur): ?>
        <p class="error"><?php echo htmlspecialchars($erreur); ?></p>
      <?php endif; ?>

    <?php endif; ?>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('mot_de_passe');
      input.type = (input.type === 'password') ? 'text' : 'password';
    }
  </script>
</body>
</html>
