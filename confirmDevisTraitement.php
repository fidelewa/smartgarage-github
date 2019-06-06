<?php
include_once('config.php');
// include_once('header.php');

// var_dump($_GET['confirm_devis']);

// Lorsque le client clique sur le lien de confirmation du devis envoyé par e-mail,
// On enregistre la valeur de la confirmation en base de données
$query = "UPDATE tbl_add_devis SET confirm_devis='" . $_GET['confirm_devis'] . "' WHERE devis_id='" . (int)$_GET['devis_id'] . "'
AND repaircar_diagnostic_id='" . (int)$_GET['vehi_diag_id'] . "'
";

// Exécution de la requête
$result = mysql_query($query, $link);

// Vérification du résultat de la requête et affichage d'un message en cas d'erreur
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation du devis</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <p>Pour accèder à votre devis, veuillez vous connecter à votre espace d'administration en <a href="<?php echo WEB_URL; ?>logout.php">cliquant sur ce lien</a></p>
        </div>
    </div>
</body>

</html>