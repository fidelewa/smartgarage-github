<?php
include('../header.php');

if (isset($_GET['car_id']) && $_GET['car_id'] != '') {

    // On récupère les infos de
    $row = $wms->getRepairCarInfoByRepairCarId($link, $_GET['car_id']);

    // var_dump($row);

    // die();

    // Traitement de l'assurance
    if (isset($row['add_date_assurance']) && $row['add_date_assurance_fin'] != '') {

        // On récupère les données d'historisation du véhicule courant
        $rows = $wms->getHistoAssurVehi($link, $row['add_date_assurance'], $row['add_date_assurance_fin'], $_GET['car_id']);

        // Si aucun enregistrement ne correspond à notre recherche
        if (empty($rows)) {

            // On insère le nouvel enregistrement dans la table d'historisation des assurances
            $query = "INSERT INTO tbl_histo_assurance (date_debut_assurance, date_fin_assurance, duree_assurance, car_id) 
        VALUES('$row[add_date_assurance]','$row[add_date_assurance_fin]',null,'$_GET[car_id]')";

            // Exécution de la requête
            $result_histo_assurance = mysql_query($query, $link);

            // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
            if (!$result_histo_assurance) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
        }
    }

    // Traitement de la visite technique
    if (isset($row['add_date_visitetech'])) {

        // On récupère les données d'historisation du véhicule courant
        $rows = $wms->getHistoVistechVehi($link, $row['add_date_visitetech'], $_GET['car_id']);

        // Si aucun enregistrement ne correspond à notre recherche
        if (empty($rows)) {

            // On insère le nouvel enregistrement dans la table d'historisation des assurances
            $query = "INSERT INTO tbl_histo_visite_technique (date_prochaine_visitetech, duree_visitetech, car_id) 
        VALUES('$row[add_date_visitetech]',null, '$_GET[car_id]')";

            // Exécution de la requête
            $result_histo_visetech = mysql_query($query, $link);

            // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
            if (!$result_histo_visetech) {
                $message  = 'Invalid query: ' . mysql_error() . "\n";
                $message .= 'Whole query: ' . $query;
                die($message);
            }
        }
    }
}

$result_3 = $wms->getAllAvancePrimeListByEmploye($link, $_GET['per_id']);

// var_dump($result);

// Déclaration et initialisation des compteurs d'incrémentation
$i = 1;
$j = 1;

?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> Historique des avances et des primes sur le salaire de l'employé <?php
                                                                            if (isset($result_3) && !empty($result_3)) {
                                                                                echo '<b>' . $result_3[0]['per_name'] . '</b>';
                                                                            }
                                                                            ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li class="active">Car Setting</li>
        <li class="active">Make/Model/Year</li> -->
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div align="right" style="margin-bottom:1%;">
                <a class="btn btn-success" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/histo_avance_prime_emp.php?per_id=<?php echo $_GET['per_id']; ?>" data-original-title="Re-charger la page"><i class="fa fa-refresh"></i></a>
                <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/listepersonnel.php" data-original-title="Retour"><i class="fa fa-reply"></i></a>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <div class="box-header">
                        <h3 class="box-title">Historique des avances sur salaire de l'employé <?php
                                                                                                if (isset($result_3) && !empty($result_3)) {
                                                                                                    echo '<b>' . $result_3[0]['per_name'] . '</b>';
                                                                                                }
                                                                                                ?></h3>
                    </div>
                    <br>
                    <div>
                        <table class="table sakotable table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Date de l'avance</th>
                                    <th>Montant de l'avance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $result_avance = $wms->getHistoAvanceListByPerId($link, $_GET['per_id']);

                                // var_dump($result);
                                // die();

                                foreach ($result_avance as $ligne_avance) { ?>
                                    <tr>
                                        <td><?php echo date_format(date_create($ligne_avance['date_avance']), 'd/m/Y'); ?></td>
                                        <td id="montant_avance_<?php echo $i; ?>"><?php echo $ligne_avance['montant_avance']; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }

                                // On retourne la représentation JSON du tableau
                                $result_avance_json = json_encode($result_avance);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box box-success" id="box_model">
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="box-header">
                            <h3 class="box-title">Historique des primes sur salaire de l'employé <?php
                                                                                                    if (isset($result_3) && !empty($result_3)) {
                                                                                                        echo '<b>' . $result_3[0]['per_name'] . '</b>';
                                                                                                    }
                                                                                                    ?></h3>
                        </div>
                        <br>
                        <div>
                            <table class="table sakotable table-bordered table-striped dt-responsive">
                                <thead>
                                    <tr>
                                        <th>Date de la prime</th>
                                        <th>Montant de la prime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $result_prime = $wms->getHistoPrimeListByPerId($link, $_GET['per_id']);
                                    foreach ($result_prime as $ligne_prime) { ?>
                                        <tr>
                                            <td><?php echo date_format(date_create($ligne_prime['date_prime']), 'd/m/Y'); ?></td>
                                            <td id="montant_prime_<?php echo $j; ?>"><?php echo $ligne_prime['montant_prime']; ?></td>
                                        </tr>
                                        <?php
                                        $j++;
                                    }

                                    // On retourne la représentation JSON du tableau
                                    $result_prime_json = json_encode($result_prime);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    // Définition de la locale en français
    numeral.register('locale', 'fr', {
        delimiters: {
            thousands: ' ',
            decimal: ','
        },
        abbreviations: {
            thousand: 'k',
            million: 'm',
            billion: 'b',
            trillion: 't'
        },
        currency: {
            symbol: 'FCFA'
        }
    });

    // Sélection de la locale en français
    numeral.locale('fr');

    // analyse de la chaîne de caractères JSON et 
    // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
    var result_avance_obj = JSON.parse('<?= $result_avance_json; ?>');
    var result_prime_obj = JSON.parse('<?= $result_prime_json ?>');

    // Déclaration et initialisation de l'objet itérateur
    var iterateur_avance = result_avance_obj.keys();
    var iterateur_prime = result_prime_obj.keys();

    // Déclaration et initialisation de l'indice
    var row_avance = iterateur_avance.next().value + 1;
    var row_prime = iterateur_prime.next().value + 1;

    // Parcours du tableau d'objet
    for (const key of result_avance_obj) {

        // Conversion en flottant
        key.montant_avance = parseFloat(key.montant_avance);

        // Affectation des nouvelles valeurs
        $("#montant_avance_" + row_avance).html(numeral(key.montant_avance).format('0,0 $'));

        // Incrémentation du compteur
        row_avance++;
    }

    // Parcours du tableau d'objet
    for (const key of result_prime_obj) {

        // Conversion en flottant
        key.montant_prime = parseFloat(key.montant_prime);

        // Affectation des nouvelles valeurs
        $("#montant_prime_" + row_prime).html(numeral(key.montant_prime).format('0,0 $'));

        // Incrémentation du compteur
        row_prime++;
    }
</script>
<!-- /.row -->
<?php include('../footer.php'); ?>