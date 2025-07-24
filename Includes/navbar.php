<?php

// Exemple de barre de navigation simple avec liens vers pages principales

?>

<nav style="
  background-color: #0077cc;
  padding: 12px 20px;
  display: flex;
  justify-content: center;
  gap: 40px;
  font-family: Arial, sans-serif;
  box-shadow: 0 2px 5px rgba(0,0,0,0.15);">

  <a href="ajouter_cours.php" style="color: white; text-decoration: none;">Ajouter un cours</a> 
  <a href="modifier_cours.php" style="color: white; text-decoration: none;">Modifier un cours</a>
  <a href="supprimer_cours.php" style="color: white; text-decoration: none;">Supprimer un cours</a>
  <a href="student.php" style="color: white; text-decoration: none;">Espace étudiant</a>
  <a href="liste_des_professeur.php" style="color: white; text-decoration: none;">Espace professeur</a>
</nav>
