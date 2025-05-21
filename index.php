<?php
session_start();

if (isset($_SESSION['utilisateur'])) {
    // Redirection automatique selon le rôle
    if ($_SESSION['utilisateur']['role'] === 'professeur') {
        header("Location: prof.php");
        exit();
    } elseif ($_SESSION['utilisateur']['role'] === 'etudiant') {
        header("Location: etudiant.php");
        exit();
    }
} else {
    // Si non connecté, aller vers la page de login
    header("Location: login.php");
    exit();
}
