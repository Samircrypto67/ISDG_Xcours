<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: login.php");
    exit;
}

// Récupérer les infos de l'étudiant
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les cours
$cours_stmt = $pdo->prepare("SELECT * FROM cours");
$cours_stmt->execute();
$cours = $cours_stmt->fetchAll(PDO::FETCH_ASSOC);

// Définir la photo (image par défaut si vide)
$photo = !empty($etudiant['photo']) ? htmlspecialchars($etudiant['photo']) : 'https://via.placeholder.com/150?text=Photo';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Étudiant - ISDG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">
    <div class="container mt-4">
        <div class="text-center p-4 bg-primary text-white rounded">
            <h1>Bienvenue sur ISDG - Espace Étudiant</h1>
        </div>

        <div class="mt-5">
            <h3>📚 Liste des cours disponibles</h3>
            <table class="table table-bordered table-hover table table-striped"> 
                <thead>
                    <tr>
                        <th>Jour</th>      
                        <th>Cours</th>
                        <th>Heure</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cours)): ?>
                        <?php foreach ($cours as $cours_item): ?>
                            <tr>
                                <td><?= htmlspecialchars($cours_item['jour'] ?? '') ?></td>
                                <td><?= htmlspecialchars($cours_item['nom'] ?? '') ?></td>
                                <td><?= htmlspecialchars($cours_item['heure'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                     <?php else: ?>
                        <tr>
                            <td colspan="3">Aucun cours disponible.</td>"
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>     
        </div>

        <div class="mt-5">
            <h3>📖 Le Compendium</h3>
            <div class="card p-4">
                <div class="text-center">
                    <img src="<?= $photo ?>" alt="Photo Étudiant" class="rounded-circle mb-3" width="150">
                    <h4><?= htmlspecialchars(($etudiant['prenom'] ?? '') . ' ' . ($etudiant['nom'] ?? '')) ?></h4>
                </div>
                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item"><strong>Date de naissance :</strong> <?= htmlspecialchars($etudiant['date_naissance'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Pays d'origine :</strong> <?= htmlspecialchars($etudiant['pays'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Formation :</strong> <?= htmlspecialchars($etudiant['formation'] ?? '') ?></li>
                    <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($etudiant['email'] ?? '') ?></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>