<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$isProf = ($_SESSION['role'] === 'professeur');

$stmt = $pdo->query("SELECT * FROM cours ORDER BY jour, heure");
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des cours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">📚 Liste des cours</h2>

                <?php if (count($cours) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nom</th>
                                    <th>Jour</th>
                                    <th>Heure</th>
                                    <?php if ($isProf): ?>
                                        <th>Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cours as $c): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($c['nom']) ?></td>
                                        <td><?= htmlspecialchars($c['jour']) ?></td>
                                        <td><?= htmlspecialchars(substr($c['heure'], 0, 5)) ?></td>
                                        <?php if ($isProf): ?>
                                            <td>
                                                <a href="modifier_cours.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning me-2">✏️ Modifier</a>
                                                <a href="supprimer_cours.php?id=<?= $c['id'] ?>" onclick="return confirm('Supprimer ce cours ?')" class="btn btn-sm btn-danger">❌ Supprimer</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">Aucun cours enregistré.</p>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <a href="<?= $isProf ? 'prof.php' : 'etudiant.php' ?>" class="btn btn-secondary">⬅ Retour</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>