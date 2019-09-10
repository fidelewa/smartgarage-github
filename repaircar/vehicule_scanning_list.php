<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
$error_info = 'none';
$msg_error = "";
$error_info_2 = 'none';
$msg_error_2 = "";
$error_info_3 = 'none';
$msg_error_3 = "";
$error_info_4 = 'none';
$msg_error_4 = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteCustomer($link, $_GET['id']);
    $delinfo = 'block';
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "Véhicule mis en attente de reception et de scannage";
}
// if (isset($_GET['m']) && $_GET['m'] == 'up') {
//   $addinfo = 'block';
//   $msg = "Informations client mises à jour avec succès";
// }

if (isset($_GET['m']) && $_GET['m'] == 'recu_scanning_check') {
    $addinfo = 'block';
    $msg = "Le reçu de paiement du scanner à été validé";
}

if (isset($_GET['m']) && $_GET['m'] == 'scanner_error') {
    $error_info = 'block';
    $msg_error = "Veuillez sélectionner au moin un type de scanner";
}

// if (isset($_GET['m']) && $_GET['m'] == 'scanner_error_deux') {
//     $error_info_2 = 'block';
//     $msg_error_2 = "Veuillez cocher les deux types de scanner SVP !!!";
// }

// if (isset($_GET['m']) && $_GET['m'] == 'scanner_error_un') {
//     $error_info_3 = 'block';
//     $msg_error_3 = "Veuillez cocher un seul type de scanner SVP !!!";
// }

if (isset($_GET['m']) && $_GET['m'] == 'scanner_error_50k') {
    $error_info_2 = 'block';
    $msg_error_2 = "Veuillez saisir un montant égal à 50 000 FCFA lorsque vous choisissez un seul type de scanner SVP !!!";
}

if (isset($_GET['m']) && $_GET['m'] == 'scanner_error_100k') {
    $error_info_3 = 'block';
    $msg_error_3 = "Veuillez saisir un montant égal à 100 000 FCFA lorsque vous choisissez les deux types de scanner SVP !!!";
}

if (isset($_GET['m']) && $_GET['m'] == 'nom_client_incorrect_format') {
    $error_info_4 = 'block';
    $msg_error_4 = "le format du nom du client est incorrect, il doit être de la forme nom_client//numero_telephone";
}

$i = 0;
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> <i class="fa fa-list"></i> Liste des véhicules à réceptionner et à scanner </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des véhicules à réceptionner et à scanner</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-ban"></i> Suppression!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Succès!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="his" class="alert alert-error alert-dismissable" style="display:<?php echo $error_info; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Erreur!</h4>
                <?php echo $msg_error; ?>
            </div>
            <div id="his_2" class="alert alert-error alert-dismissable" style="display:<?php echo $error_info_2; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Erreur!</h4>
                <?php echo $msg_error_2; ?>
            </div>
            <div id="his_3" class="alert alert-error alert-dismissable" style="display:<?php echo $error_info_3; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Erreur!</h4>
                <?php echo $msg_error_3; ?>
            </div>
            <div id="his_4" class="alert alert-error alert-dismissable" style="display:<?php echo $error_info_4; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Erreur!</h4>
                <?php echo $msg_error_4; ?>
            </div>
            <div align="right" style="margin-bottom:1%;">
                <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/adduser.php" data-original-title="Ajouter un utilisateur"><i class="fa fa-plus"></i></a>  -->
                <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>servcli_panel/servcli_dashboard.php" data-original-title="Aller au tableau de bord"><i class="fa fa-dashboard"></i></a>
            </div>
            <div class="box box-success">
                <!-- <div class="box-header">
                    <h3 class="box-title">Liste des véhicules à scanner</h3>
                </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom client</th>
                                <th>Numéro téléphone</th>
                                <th>Immatriculation</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Scanner mécanique</th>
                                <th>Scanner électrique</th>
                                <th>Frais de scanner</th>
                                <th>Statut reçu scanner</th>
                                <th>Statut scanner</th>
                                <th>Statut reception</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $results = $wms->getCarScanning($link);
                            foreach ($results as $row) {
                                // $image = WEB_URL . 'img/no_image.jpg';
                                // if(file_exists(ROOT_PATH . '/img/upload/' . $row['usr_image']) && $row['usr_image'] != ''){
                                // 	$image = WEB_URL . 'img/upload/' . $row['usr_image'];
                                // }
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['c_name']; ?></td>
                                    <td><?php echo $row['princ_tel']; ?></td>
                                    <td><?php echo $row['imma_vehi_client']; ?></td>
                                    <td><?php echo $row['marque_vehi_client']; ?></td>
                                    <td><?php echo $row['model_vehi_client']; ?></td>
                                    <td><?php echo $row['scanner_mecanique']; ?></td>
                                    <td><?php echo $row['scanner_electrique']; ?></td>
                                    <td id="frais_scanner_<?php echo $i; ?>"><?php echo $row['frais_scanner']; ?></td>
                                    <td><?php
                                            if ($row['validation_recu_scanning'] == null) {
                                                echo "<span class='label label-default'>Non validé</span> <br/>";
                                            } else if ($row['validation_recu_scanning'] == 1) {
                                                echo "<span class='label label-success'>validé</span> <br/>";
                                            }
                                            ?></td>
                                    <td><?php
                                            if ($row['statut_scannage'] == null) {
                                                echo "<span class='label label-default'>En attente de scan</span> <br/>";
                                            } else if ($row['statut_scannage'] == 1) {
                                                echo "<span class='label label-success'>Scan effectué</span> <br/>";
                                            }
                                            ?></td>
                                    <td><?php
                                            if ($row['statut_reception'] == null) {
                                                echo "<span class='label label-default'>En attente de reception</span> <br/>";
                                            } else if ($row['statut_reception'] == 1) {
                                                echo "<span class='label label-success'>Reception effectuée</span> <br/>";
                                            }
                                            ?></td>
                                    <td>
                                        <?php if ($_SESSION['login_type'] == 'comptable') { ?>
                                            <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>servcli_panel/recu_paiement_scanner.php?nbr_aleatoire=<?php echo $row['nbr_aleatoire']; ?>" data-original-title="Afficher le reçu de paiement du scanner">Imprimer le reçu de paiement du scanner</a>
                                            <?php if ($row['validation_recu_scanning'] == null) { ?>
                                                <a class="btn btn-info" style="background-color:green;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>compta_panel/validation_recu_scanning.php?recu_scanning_id=<?php echo $row['id']; ?>" data-original-title="valider le reçu de paiement du scanner">Valider le reçu de paiement du scanner</a>
                                        <?php }
                                            } ?>
                                    </td>
                                </tr>
                            <?php
                                $i++;
                            }

                            // On retourne la représentation JSON du tableau
                            $scanner_data_json = json_encode($results, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
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

        // Initialisation des variables
        var frais_scanner = "<?php echo $row['frais_scanner']; ?>";

        // analyse de la chaîne de caractères JSON et 
        // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
        var scanner_data_obj = JSON.parse('<?= $scanner_data_json; ?>');

        // console.log(scanner_data_obj);

        // Déclaration et initialisation de l'objet itérateur
        var iterateur = scanner_data_obj.keys();

        // Déclaration et initialisation de l'indice ou compteur
        var row = iterateur.next().value;

        // Parcours du tableau d'objet
        for (const key of scanner_data_obj) {

            // Conversion en flottant
            key.frais_scanner = parseFloat(key.frais_scanner);

            console.log(numeral(key.frais_scanner).format('0,0 $'));

            // Affectation des nouvelles valeurs
            $("#frais_scanner_" + row).html(numeral(key.frais_scanner).format('0,0 $'));

            // incrémentation du compteur
            row++;

        }

        // Conversion des variables en flottant
        frais_scanner = parseFloat(frais_scanner);

        // console.log(numeral(frais_scanner).format('0,0 $'));

        // console.log($("#salaire_base_scanner"));

        $("#frais_scanner").html(numeral(frais_scanner).format('0,0 $'));

        function deleteSupplier(Id) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>user/userlist.php?id=' + Id;
            }
        }

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(8000);
                $("#you").hide(8000);
                $("#his").hide(8000);
                $("#his_2").hide(8000);
                $("#his_3").hide(8000);
                $("#his_4").hide(8000);
            }, 8000);
        });
    </script>
    <?php include('../footer.php'); ?>