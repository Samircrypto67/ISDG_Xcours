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