<?php

// On récupère le lien de connexion à la BDD
include("../config.php");
// On récupère la classe wms_core
include("../helper/common.php");

// On instancie le constructeur implicite de la classe wms_core
$wms = new wms_core();

if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // On récupère la quantité actuelle du stock de l'article à partir de son identifiant
    $existing_parts = $wms->getPieceCurrentStockByPieceId($link, (int)$_POST['piece_id']);

    // var_dump($existing_parts);
    // die();

    // S'il y a un enregistement correspondant à l'article dont l'identifiant est passé en paramètre
    // On récupère la valeur de son stock actuel
    if (!empty($existing_parts)) {

        $currentQty = $existing_parts['stock_piece'];
    }

    // Exécution de la requête paramètrée de mise à jour du stock
    $wms->updatePieceStock($link, $_POST, $currentQty);

    // Lorsque le stock est modifié, on fait une redirection vers
    // la liste des mouvements de stock des articles 

    $url = WEB_URL . "parts_stock/mouvstock.php?m=modif_article_stock&code_piece=".$existing_parts['code_piece']."&lib_piece=".$existing_parts['lib_piece'];
    header("Location: $url");
}
