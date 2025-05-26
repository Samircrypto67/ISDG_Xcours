<?php
$mot_de_passe = "etudiant123";

// Génération du hash
$hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// Affichage
echo "Mot de passe : $mot_de_passe<br>";
echo "Hash : $hash";
?>
