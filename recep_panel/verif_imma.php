<?php
include('../helper/common.php');
include_once('../config.php');

//Requête 
$result = mysql_query("SELECT VIN FROM tbl_add_car WHERE VIN='".$_GET["imma"]."'", $link);

if(mysql_num_rows($result)>=1)
echo "<span style='color:#1A7917'><b>".$_GET["imma"].":</b> cette immatriculation correspond à un véhicule</span>";
else
echo "<span style='color:#cc0000'><b>".$_GET["imma"].":</b> aucun véhicule ne possède cette immatriculation, veuillez l'enregistrer en cliquant sur le bouton d'ajout</span>";