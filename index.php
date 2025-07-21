<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['utilisateur']['role'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title>ISDG - Accueil Slide</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
        }

        /* Navbar fixe */
        nav.navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            background-color: #004080;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            z-index: 1000;
            font-weight: bold;
            font-size: 18px;
        }

        /* Pour ne pas que la navbar cache le contenu */
        .content-wrapper {
            padding-top: 60px; /* hauteur navbar + marge */
            height: 100vh;
            position: relative;
        }

        .section {
            height: 100vh;
            width: 100vw;
            position: absolute;
            top: 100%;
            left: 0;
            transition: top 0.8s ease-in-out;
            overflow-y: auto;
            background-color: white;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
            padding: 20px;
        }

        .section.active {
            top: 0;
        }

        .nav-buttons {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 999;
        }

        .nav-buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .nav-buttons button:hover {
            background-color: #002850;
        }

        /* Style bouton retour (à adapter dans includes/retour.php) */
        .retour-btn {
            position: fixed;
            top: 10px;
            right: 20px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            cursor: pointer;
            z-index: 1100;
            font-size: 14px;
        }
        .retour-btn:hover {
            background-color: #004080;
        }
    </style>
</head>
<body>

<!-- Navbar fixe -->
<nav class="navbar-fixed">
    ISDG - Espace Utilisateur (rôle : <?php echo htmlspecialchars($role); ?>)
</nav>

<div class="content-wrapper">
    <!-- Sections -->
    <div class="section active" id="section1">
        <?php include("prof.php"); ?>
    </div>
    <div class="section" id="section2">
        <?php include("etudiant.php"); ?>
    </div>
    <div class="section" id="section3">
        <?php include("ajouter_cours.php"); ?>
    </div>
    <div class="section" id="section4">
        <?php include("modifier_cours.php"); ?>
    </div>
    <div class="section" id="section5">
        <?php include("supprimer_cours.php"); ?>
    </div>
</div>

<!-- Bouton Retour -->
<?php include 'includes/retour.php'; ?>

<!-- Navigation entre sections -->
<div class="nav-buttons">
    <button onclick="goPrev()">⬆ Précédent</button>
    <button onclick="goNext()">⬇ Suivant</button>
</div>

<script>
    let sections = document.querySelectorAll(".section");
    let current = 0;

    function updateSections() {
        sections.forEach((section, index) => {
            section.style.top = ((index - current) * 100) + "vh";
            if(index === current){
                section.classList.add('active');
            } else {
                section.classList.remove('active');
            }
        });
    }

    function goNext() {
        if (current < sections.length - 1) {
            current++;
            updateSections();
        }
    }

    function goPrev() {
        if (current > 0) {
            current--;
            updateSections();
        }
    }

    // Initialiser la position au chargement
    updateSections();
</script>

</body>
</html>