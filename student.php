<?php
require_once 'db.php';

// Récupération des spécialités
$specialitesStmt = $pdo->query("SELECT DISTINCT specialite FROM users WHERE specialite IS NOT NULL AND specialite != ''");
$specialites = $specialitesStmt->fetchAll(PDO::FETCH_COLUMN);

// Traitement d’envoi de document
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $etudiant_id = $_POST['etudiant_id'];
    $fichier = $_FILES['document'];

    if ($fichier['error'] === UPLOAD_ERR_OK) {
        $nomFichier = basename($fichier['name']);
        $chemin = 'uploads/' . uniqid() . '_' . $nomFichier;
        move_uploaded_file($fichier['tmp_name'], $chemin);

        $stmt = $pdo->prepare("INSERT INTO documents (etudiant_id, nom_fichier, chemin_fichier) VALUES (?, ?, ?)");
        $stmt->execute([$etudiant_id, $nomFichier, $chemin]);
    }
}

// Récupération des données
$data = [];
foreach ($specialites as $specialite) {
    // Professeurs
    $profStmt = $pdo->prepare("SELECT prenom, nom FROM users WHERE specialite = ? AND role = 'professeur'");
    $profStmt->execute([$specialite]);
    $professeurs = $profStmt->fetchAll(PDO::FETCH_ASSOC);

    // Étudiants
    $etuStmt = $pdo->prepare("SELECT id, prenom, nom FROM users WHERE specialite = ? AND role = 'etudiant'");
    $etuStmt->execute([$specialite]);
    $etudiants = $etuStmt->fetchAll(PDO::FETCH_ASSOC);

    // Présence : pour chaque étudiant, obtenir la présence du mois
    foreach ($etudiants as &$etudiant) {
        $daysInMonth = date('t');
        $currentMonth = date('Y-m');
        $etudiant['presences'] = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%s-%02d', $currentMonth, $day);
            $stmt = $pdo->prepare("SELECT present FROM presences WHERE etudiant_id = ? AND date_presence = ?");
            $stmt->execute([$etudiant['id'], $date]);
            $present = $stmt->fetchColumn();
            $etudiant['presences'][$day] = $present ? true : false;
        }
    }

    $data[$specialite] = [
        'professeurs' => $professeurs,
        'etudiants' => $etudiants
    ];
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Spécialités ISDG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="display-5 text-primary fw-bold">Spécialités - Professeurs & Étudiants</h1>
            <p class="lead text-muted">Découvrez les membres de chaque spécialité à l’ISDG</p>
        </div>

        <?php foreach ($data as $specialite => $groupe): ?>
            <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">📚 <?= htmlspecialchars($specialite) ?></h4>
    </div>
    <div class="card-body row">
        <div class="col-md-6">
            <h5 class="text-success">👨‍🏫 Professeurs</h5>
            <?php if (!empty($groupe['professeurs'])): ?>
                <ul class="list-group">
                    <?php foreach ($groupe['professeurs'] as $prof): ?>
                        <li class="list-group-item"><?= htmlspecialchars($prof['prenom'] . ' ' . $prof['nom']) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">Aucun professeur enregistré.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h5 class="text-info">🎓 Étudiants</h5>
            <?php if (!empty($groupe['etudiants'])): ?>
                <ul class="list-group">
                    <?php foreach ($groupe['etudiants'] as $etu): ?>
                        <li class="list-group-item">
                            <strong><?= htmlspecialchars($etu['prenom'] . ' ' . $etu['nom']) ?></strong>
                            
                            <!-- Envoi de document -->
                            <form method="POST" enctype="multipart/form-data" class="mt-2 d-flex gap-2">
                                <input type="hidden" name="etudiant_id" value="<?= $etu['id'] ?>">
                                <input type="file" name="document" required class="form-control form-control-sm">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Envoyer</button>
                            </form>

                            <!-- Affichage de présence -->
                            <div class="d-flex flex-wrap mt-2">
                                <?php foreach ($etu['presences'] as $jour => $present): ?>
                                    <div title="Jour <?= $jour ?>" style="width: 20px; height: 20px; margin: 2px; border-radius: 50%; background-color: <?= $present ? '#28a745' : '#ccc' ?>;"></div>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">Aucun étudiant enregistré.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

        <?php endforeach; ?>

        <div class="mt-4">
            <?php include("Includes/retour_prof.php"); ?>
        </div>
    </div>
</body>
</html>
