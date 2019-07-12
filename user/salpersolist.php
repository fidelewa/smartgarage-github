<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deletePersoInfo($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "Suppression des informations du personnel réussi";
}

//	add success
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "Informations d'un membre du personnel ajouté avec succès";
    unset($_SESSION['token']);
}
//	add success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'nb_jour_conge_paye') {
    $addinfo = 'block';
    $msg = "Nombre de jours payés ajouté avec succès";
}

if (isset($_SESSION['token']) && $_SESSION['token'] == 'nb_jour_absence') {
    $addinfo = 'block';
    $msg = "Nombre de jours d'absence ajouté avec succès";
}

//	update success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'up') {
    $addinfo = 'block';
    $msg = "Informations d'un membre du personnel modifiées avec succès";
    unset($_SESSION['token']);
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $_SESSION['token'] = 'add';
    $url = WEB_URL . 'user/listepersonnel.php';
    header("Location: $url");
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $_SESSION['token'] = 'up';
    $url = WEB_URL . 'user/listepersonnel.php';
    header("Location: $url");
}

if (isset($_GET['m']) && $_GET['m'] == 'prime_perso') {
    $addinfo = 'block';
    $msg = "Prime attribuée avec succès";
  }
  
  if (isset($_GET['m']) && $_GET['m'] == 'avance_perso') {
    $addinfo = 'block';
    $msg = "Avance attribuée avec succès";
  }

  if (isset($_GET['m']) && $_GET['m'] == 'salnet_perso') {
    $addinfo = 'block';
    $msg = "Salaire net défini avec succès";
  }

  if (isset($_GET['m']) && $_GET['m'] == 'erreur_avance_perso') {
    $delinfo = 'block';
    $msg = "Impossible de donner l'avance car elle est supérieure au salaire de base";
  }

// Récupération du numéro du mois de la date courante

$dateDuJour = new \Datetime("now");
$numeroMoisDateJour = $dateDuJour->format('n');
$AnneeDateJour = $dateDuJour->format('Y');

if ($numeroMoisDateJour == "1") {
    $dateMoisJour = "Janvier";
} else if ($numeroMoisDateJour == "2") {
    $dateMoisJour = "Févier";
} else if ($numeroMoisDateJour == "3") {
    $dateMoisJour = "Mars";
} else if ($numeroMoisDateJour == "4") {
    $dateMoisJour = "Avril";
} else if ($numeroMoisDateJour == "5") {
    $dateMoisJour = "Mai";
} else if ($numeroMoisDateJour == "6") {
    $dateMoisJour = "Juin";
} else if ($numeroMoisDateJour == "7") {
    $dateMoisJour = "Juillet";
} else if ($numeroMoisDateJour == "8") {
    $dateMoisJour = "Août";
} else if ($numeroMoisDateJour == "9") {
    $dateMoisJour = "Septembre";
} else if ($numeroMoisDateJour == "10") {
    $dateMoisJour = "Octobre";
} else if ($numeroMoisDateJour == "11") {
    $dateMoisJour = "Novembre";
} else if ($numeroMoisDateJour == "12") {
    $dateMoisJour = "Décembre";
}

$i = 1;
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> Rémunération du personnel - mois de <?php echo '<b>' . strtoupper($dateMoisJour) . ' ' . $AnneeDateJour . '</b>' ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Rémunération du personnel - mois de <?php echo $dateMoisJour; ?> </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg; ?>
            </div>
            <div align="right" style="margin-bottom:1%;">
                <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/addpersonnel.php" data-original-title="Ajouter un membre du personnel"><i class="fa fa-plus"></i></a>  -->
                <!-- <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a>  -->
            </div>
            <div class="box box-success">

                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>Nom et prénoms</th>
                                <th>Salaire de base</th>
                                <th>Avance sur salaire</th>
                                <th>Prime</th>
                                <th>Nombre d'heures suplémentaires</th>
                                <th>Nombre de jours de congés payés</th>
                                <th>Nombre de jours d'absence justifiée</th>
                                <th>Salaire net à payer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // Trouver une alternative en passant par un paramètrage par exemple
                            // de la date de début et de fin de période (où période = mois par ex. avec date_debut_mois et date_fin_mois)
                            // $result_salaire_perso = $wms->getAllPersoSalaire($link, '2019-06-01', '2019-06-30');
                            $result_salaire_perso = $wms->getAllPersoSalaire($link, $numeroMoisDateJour);

                            // var_dump($result_salaire_perso);
                            // die();

                            foreach ($result_salaire_perso as $row) {

                                ?>
                                <tr>
                                    <td><?php echo $row['per_name'] ?></td>
                                    <td id="salaire_base_perso_<?php echo $i; ?>"><?php echo $row['salaire_base']; ?></td>
                                    <td id="avance_perso_<?php echo $i; ?>"><?php echo $row['montant_avance_periode']; ?></td>
                                    <td id="prime_perso_<?php echo $i; ?>"><?php echo $row['montant_prime_periode']; ?></td>
                                    <td><?php echo $row['nb_heure_sup_periode']; ?></td>
                                    <td><?php echo $row['nb_jour_conge_paye']; ?></td>
                                    <td><?php echo $row['nb_jour_abs_justifie']; ?></td>
                                    <td><?php echo $row['salnet_montant']; ?></td>
                                    <td>
                                        <a class="btn btn-success" style="background-color:#ff5733;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#avance_modal_<?php echo $row['perso_id']; ?>').modal('show');" data-original-title="Donner une avance à l'employé"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-success" style="background-color:#ff9933;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#prime_modal_<?php echo $row['perso_id']; ?>').modal('show');" data-original-title="Donner une prime à l'employé"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-success" style="background-color:#ffca33;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#conge_paye_<?php echo $row['perso_id']; ?>').modal('show');" data-original-title="Définir le nombre de jours de congés payés de l'employé"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-success" style="background-color:#f9ff33;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#abs_employ_<?php echo $row['perso_id']; ?>').modal('show');" data-original-title="Définir le nombre de jours d'absence justifiée de l'employé"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-success" style="background-color:#b9bf00;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#sal_net_modal_<?php echo $row['perso_id']; ?>').modal('show');" data-original-title="Définir le salaire net de l'employé"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>

                                <div id="abs_employ_<?php echo $row['perso_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <a class="close" data-dismiss="modal">×</a>
                                                <h3>Formulaire de saisie des jours d'absence</h3>
                                            </div>

                                            <form id="absEmployForm" name="absence_employe" role="form" enctype="multipart/form-data" method="POST" action="absence_employe_process.php">

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for="txtCName"> Nombre de jours d'absence justifiée pour le mois en cours :</label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="number" class='form-control' name="nb_jour_abs_employ" id="nb_jour_abs_employ" placeholder="Saisissez le nombre de jours d'absences justifiées pour le mois en cours">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="per_tel" value="<?php echo $row['per_telephone']; ?>">
                                                    <input type="hidden" name="perso_id" value="<?php echo $row['perso_id']; ?>">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-success" id="submit">Valider</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div id="conge_paye_<?php echo $row['perso_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <a class="close" data-dismiss="modal">×</a>
                                                <h3>Formulaire de saisie du congé payé</h3>
                                            </div>

                                            <form id="congePayeForm" name="conge_paye" role="form" enctype="multipart/form-data" method="POST" action="conge_paye_process.php">

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for="txtCName"> Nombre de jours de congés payés pour le mois en cours:</label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="number" class='form-control' name="nb_jour_conge_paye" id="nb_jour_conge_paye" placeholder="Saisissez le nombre de jours de congés payés pour le mois en cours">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="perso_id" value="<?php echo $row['perso_id']; ?>">
                                                    <input type="hidden" name="per_tel" value="<?php echo $row['per_telephone']; ?>">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-success" id="submit">Valider</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div id="prime_modal_<?php echo $row['perso_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <a class="close" data-dismiss="modal">×</a>
                                                <h3>Formulaire de l'attribution de la prime</h3>
                                            </div>

                                            <form id="primeSalForm" name="prime_sal" role="form" enctype="multipart/form-data" method="POST" action="prime_process.php">

                                                <div class="modal-body">
                                                    <!-- <?php var_dump($row['perso_id']); ?> -->

                                                    <div class="form-group">
                                                        <label for="txtCName"> Prime :</label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="number" class='form-control' name="prime_sal" id="prime_sal" placeholder="Saisissez le montant de la prime" onfocus="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="prime_pers_id" value="<?php echo $row['perso_id']; ?>">
                                                    <input type="hidden" name="prime_pers_telephone" value="<?php echo $row['per_telephone']; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-success" id="submit">Valider</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div id="avance_modal_<?php echo $row['perso_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <a class="close" data-dismiss="modal">×</a>
                                                <h3>Formulaire de l'attribution de l'avance sur salaire</h3>
                                            </div>

                                            <form id="avanceSalForm" name="avance_sal" role="form" enctype="multipart/form-data" method="POST" action="avance_process.php">

                                                <div class="modal-body">
                                                    <!-- <?php var_dump($row['perso_id']); ?> -->

                                                    <div class="form-group">
                                                        <label for="txtCName"> Avance sur salaire :</label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="number" class='form-control' name="avance_sal" id="avance_sal" placeholder="Saisissez le montant de l'avance" onfocus="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="avance_pers_id" value="<?php echo $row['perso_id']; ?>">
                                                    <input type="hidden" name="avance_pers_telephone" value="<?php echo $row['per_telephone']; ?>">
                                                    <input type="hidden" name="salaire_base_pers" value="<?php echo $row['salaire_base']; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-success" id="submit">Valider</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div id="sal_net_modal_<?php echo $row['perso_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <a class="close" data-dismiss="modal">×</a>
                                                <h3>Formulaire de saisie du salaire net</h3>
                                            </div>

                                            <form id="salNetForm" name="sal_net_form" role="form" enctype="multipart/form-data" method="POST" action="salnet_process.php">

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for="txtCName"> Salaire net :</label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input type="number" class='form-control' name="montant_salnet" id="montant_salnet" placeholder="Saisissez le montant du salaire net" onfocus="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="salnet_pers_id" value="<?php echo $row['perso_id']; ?>">
                                                    <input type="hidden" name="salnet_pers_telephone" value="<?php echo $row['per_telephone']; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-success" id="submit">Valider</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                $i++;
                            }

                            // On retourne la représentation JSON du tableau
                            $result_salaire_perso_json = json_encode($result_salaire_perso);
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

        // analyse de la chaîne de caractères JSON et 
        // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
        var result_salaire_perso_obj = JSON.parse('<?= $result_salaire_perso_json; ?>');

        // Déclaration et initialisation de l'objet itérateur
        var iterateur_salaire_perso = result_salaire_perso_obj.keys();

        // Déclaration et initialisation de l'indice
        var row_salaire_perso = iterateur_salaire_perso.next().value + 1;

        // Parcours du tableau d'objet
        for (const key of result_salaire_perso_obj) {

            // console.log(key);

            // Conversion en flottant
            key.salaire_base = parseFloat(key.salaire_base);
            key.montant_avance_periode = parseFloat(key.montant_avance_periode);
            key.montant_prime_periode = parseFloat(key.montant_prime_periode);

            console.log(numeral(key.salaire_base).format('0,0 $'));

            // Affectation des nouvelles valeurs
            $("#salaire_base_perso_" + row_salaire_perso).html(numeral(key.salaire_base).format('0,0 $'));
            $("#avance_perso_" + row_salaire_perso).html(numeral(key.montant_avance_periode).format('0,0 $'));
            $("#prime_perso_" + row_salaire_perso).html(numeral(key.montant_prime_periode).format('0,0 $'));

            // Incrémentation du compteur
            row_salaire_perso++;
        }

        function deleteSupplier(Id) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ce personnel ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>user/listepersonnel.php?id=' + Id;
            }
        }

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(300);
                $("#you").hide(300);
            }, 3000);
        });
    </script>
    <?php include('../footer.php'); ?>