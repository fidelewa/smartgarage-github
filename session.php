<?php
// start session
ob_start();
session_start();

// Si la session de l'administrateur à expirée, on redirige vers la page de déconnexion
if (!isset($_SESSION)) {
	header("Location: logout.php");
	die();
}
