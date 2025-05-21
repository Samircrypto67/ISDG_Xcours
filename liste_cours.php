<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$isProf = $_SESSION['role'] === 'professeur';

$stmt = $pdo->query("SELECT * FROM cours ORDER BY jour, heure");
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des cours</title>
</head>
<body>
    <h2>Liste des cours</h2>

    <?php if (count($cours) > 0): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Nom</th>
                <th>Jour</th>
                <th>Heure</th>
                <?php if ($isProf): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
            <?php foreach ($cours as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['nom']) ?></td>
                    <td><?= htmlspecialchars($c['jour']) ?></td>
                    <td><?= htmlspecialchars(substr($c['heure'], 0, 5)) ?></td>
                    <?php if ($isProf): ?>
                        <td>
                            <a href="modifier_cours.php?id=<?= $c['id'] ?>">✏️ Modifier</a> |
                            <a href="supprimer_cours.php?id=<?= $c['id'] ?>" onclick="return confirm('Supprimer ce cours ?')">❌ Supprimer</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun cours enregistré.</p>
    <?php endif; ?>

    <br>
    <a href="<?= $isProf ? 'prof.php' : 'etudiant.php' ?>">⬅ Retour</a>
</body>
</html>
