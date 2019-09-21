<?php
// start session
ob_start();
session_start();
// Si la session de l'administrateur à expirée, on redirige vers la page de déconnexion
// Si la variable de session d'authentification n'est pas défini

if (!isset($_SESSION['auth'])) {
	// On détruit la session puis on fait une redirection vers la sortie
	session_unset();
	session_destroy();
	header("Location: logout.php");
	die();
}
