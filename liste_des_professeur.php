<?php
require_once 'db.php'; // connexion PDO : $pdo

// Ajouter un professeur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $specialite = $_POST['specialite'] ?? '';

    if ($prenom && $nom && $specialite) {
        $stmt = $pdo->prepare("INSERT INTO users (prenom, nom, specialite, role) VALUES (?, ?, ?, 'professeur')");
        $stmt->execute([$prenom, $nom, $specialite]);
    }
}

// Supprimer un professeur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_id'])) {
    $id = $_POST['supprimer_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'professeur'");
    $stmt->execute([$id]);
}

// Récupérer tous les professeurs
$professeurs = $pdo->query("SELECT * FROM users WHERE role = 'professeur' ORDER BY specialite")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Professeurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="text-center mb-4">
        <h1 class="display-5 text-primary fw-bold">Professeurs de l’ISDG</h1>
        <p class="lead text-muted">Ajouter ou supprimer des professeurs selon leur spécialité</p>
    </div>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            Ajouter un professeur
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                </div>
                <div class="col-md-4">
                     <label for="specialite">Choisis ta spécialité :</label>
                        <select name="specialite" id="specialite" required>
                            <option value="">-- Sélectionne --</option>
                            <option value="SIO/SLAM">SLAM</option>
                            <option value="SIO/SISR">SISR</option>
                            <option value="MCO">MCO</option>
                        </select>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" name="ajouter" class="btn btn-success">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des professeurs -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Liste des professeurs
        </div>
        <ul class="list-group list-group-flush">
            <?php if (count($professeurs) > 0): ?>
                <?php foreach ($professeurs as $prof): ?>
                   <li class="list-group-item d-flex justify-content-between align-items-center">
    <span>👨‍🏫 <?= htmlspecialchars($prof['prenom'] ?? '') . ' ' . htmlspecialchars($prof['nom'] ?? '') ?> — 
    <em><?= htmlspecialchars($prof['specialite'] ?? '') ?></em></span>
    
    <form method="POST" class="mb-0">
        <input type="hidden" name="supprimer_id" value="<?= $prof['id'] ?>">
        <button type="submit" class="btn btn-outline-danger btn-sm">Supprimer</button>
    </form>
</li>

                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item text-muted">Aucun professeur enregistré.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="mt-4">
        <?php include("Includes/retour_prof.php"); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
