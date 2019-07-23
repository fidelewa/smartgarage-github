<?php
include('../header.php');

$row = 0;
$estimate_data = array();

$form_url = WEB_URL . "reception/repaircar_diagnostic_traitement.php";

$ligne = $wms->getRecepRepairCarInfoDiagnostic($link, $_GET['add_car_id'], $_GET['car_id']);

// var_dump($ligne);

// die();
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
    }

    body {
        background-color: #f1f1f1;
    }

    #regForm {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: auto;
        height: auto;
        min-width: 300px;
    }

    /* h1 {
      text-align: center;
    } */

    /* input,
    select {
      padding: 10px;
      width: 100%;
      font-size: 17px;
      font-family: Raleway;
      border: 1px solid #aaaaaa;
    } */

    /* Mark input boxes that gets an error on validation: */
    input.invalid,
    select.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    button {
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #4CAF50;
    }
</style>

<body>

    <section class="content-header">
        <h1> Formulaire de création de la fiche de diagnostic d'un véhicule</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo WEB_URL ?>repaircar/carlist.php"> véhicule à faire réparer</a></li>
            <li class="active">Ajout de véhicule à faire réparer</li>
        </ol>
    </section>

    <div class="container">
        <!-- Main content -->
        <form action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data" id="regForm">
            <section class="content">

                <!-- One "tab" for each step in the form: -->

                <div class="tab">
                    <h1 style="text-align:center;">Récapitulatif des informations du client et du véhicule</h1>
                    <br>
                    <p>
                        <div class="form-group row">
                            <label for="nom_client" class="col-md-3 col-form-label">Nom du client :</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="nom_client" name="nom_client" value="<?php echo $ligne['c_name'] ?>" class="form-control">
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="form-group row">
                            <label for="tel_wa_client" class="col-md-3 col-form-label">Contact (whatsapp) du client :</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="tel_wa_client" name="tel_wa_client" value="<?php echo $ligne['tel_wa'] ?>" class="form-control">
                            </div>
                        </div>
                    </p>
                    <!-- <p>
                        <div class="form-group row">
                            <label for="type_vehicule" class="col-md-3 col-form-label">Type du véhicule</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="type_vehicule" name="type_vehicule" value="<?php echo $ligne['energie'] ?>" class="form-control">
                            </div>
                        </div>
                    </p> -->
                    <!-- <p>
                        <div class="form-group row">
                            <label for="type_vehicule" class="col-md-3 col-form-label">Type du véhicule</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="type_vehicule" name="type_vehicule" value="<?php echo $ligne['genre'] ?>" class="form-control">
                            </div>
                        </div>
                    </p> -->
                    <p>
                        <div class="form-group row">
                            <label for="type_vehicule" class="col-md-3 col-form-label">Type du véhicule :</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="type_vehicule" name="type_vehicule" value="<?php echo $ligne['type_boite_vitesse'] ?>" class="form-control">
                            </div>
                        </div>
                    </p>
                    <p>
                        <div class="form-group row">
                            <label for="imma_vehicule" class="col-md-3 col-form-label">Immatriculation du véhicule :</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="imma_vehicule" name="imma_vehicule" value="<?php echo $ligne['VIN'] ?>" class="form-control">
                            </div>
                        </div>
                    </p>

                    <p>
                        <div class="form-group row">
                            <label for="num_chasis_vehicule" class="col-md-3 col-form-label">N° Chassis du véhicule :</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="num_chasis_vehicule" name="num_chasis_vehicule" value="<?php echo $ligne['chasis_no'] ?>" class="form-control">
                            </div>
                        </div>
                    </p>

                    <p>
                        <div class="form-group row">
                            <label for="marque_vehicule" class="col-md-3 col-form-label">Marque du véhiclule :</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="marque_vehicule" name="marque_vehicule" value="<?php echo $ligne['make_name'] ?>" class="form-control">
                            </div>
                        </div>
                    </p>

                    <p>
                        <div class="form-group row">
                            <label for="modele_vehicule" class="col-md-3 col-form-label">Modèle du véhiclule :</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="modele_vehicule" name="modele_vehicule" value="<?php echo $ligne['model_name'] ?>" class="form-control">
                            </div>
                        </div>
                    </p>

                    <p>
                        <div class="form-group row">
                            <label for="date_creation_fiche_diag" class="col-md-3 col-form-label">Date de création de la fiche:</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input readonly type="text" id="date_creation_fiche_diag" name="date_creation_fiche_diag" value="<?php echo date('d/m/Y') ?>" class="form-control">
                            </div>
                        </div>
                    </p>
                </div>

                <div class="tab">
                    <h1 style="text-align:center;">Disfonctionnement et pannes enregistrées</h1>

                    <div class="container" style="width:auto;">
                        <div class="form-group row">
                            <label for="rapport_diagnostic" class="col-md-3 col-form-label">Rapport de diagnostic</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <textarea class="form-control" id="rapport_diagnostic" rows="10" name="rapport_diagnostic"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab">
                    <h1 style="text-align:center;">Enregistrement des pièces de rechange</h1>

                    <div class="box box-success" id="box_model">
                        <div class="box-header">
                            <h3 class="box-title"> Pièces de rechange réquis</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table id="labour_table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><b> Désignation </b></th>
                                                <!-- <th class="text-center"><b>Prix(<?php echo $currency; ?>)</b></th> -->
                                                <th class="text-center"><b> Quantité </b></th>
                                                <!-- <th class="text-center"><b>Montant</b></th> -->
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($estimate_data as $estimate) { ?>
                                                <tr id="estimate-row<?php echo $row; ?>">
                                                    <td class="text-right"><input id="parts_desc_<?php echo $row; ?>" type="text" value="" name="estimate_data[<?php echo $row; ?>][designation]" class="form-control" /></td>
                                                    <!-- <td class="text-right"><input type="text" id="price_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][price]" value="" class="form-control eFire allownumberonly" /></td> -->
                                                    <td class="text-right"><input id="qty_<?php echo $row; ?>" type="text" name="estimate_data[<?php echo $row; ?>][quantity]" value="" class="form-control eFire allownumberonly" /></td>
                                                    <!-- <td class="text-right"><input type="text" id="total_<?php echo $row; ?>" name="estimate_data[<?php echo $row; ?>][total]" value="" class="form-control etotal allownumberonly" /></td> -->
                                                    <td class="text-left"><button type="button" onclick="$('#estimate-row<?php echo $row; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                </tr>
                                                <?php $row++;
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9"></td>
                                                <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Add Estimate" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                            <!-- <tr>
                                                <td colspan="8" class="text-right">Total(<?php echo $currency; ?>):</td>
                                                <td><input id="total_price" type="text" value="<?php echo ""; ?>" disabled="disabled" class="form-control allownumberonly" /></td>
                                                <td>&nbsp;</td>
                                            </tr> -->
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab">
                    <h1 style="text-align:center;">A préciser au client</h1>

                    <!-- <p>
                        <div class="form-group row">
                            <label for="duree_commande" class="col-md-3 col-form-label">Durée de la commande</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input type="text" id="duree_commande" name="duree_commande" value="" class="form-control">
                            </div>
                        </div>
                    </p> -->

                    <p>
                        <div class="form-group row">
                            <label for="duree_travaux" class="col-md-3 col-form-label">Durée des travaux</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input type="text" id="duree_travaux" name="duree_travaux" value="" class="form-control">
                            </div>
                        </div>
                    </p>

                    <p>
                        <div class="form-group row">
                            <label for="travaux_prevoir" class="col-md-3 col-form-label">Travaux à prévoir</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input type="text" id="travaux_prevoir" name="travaux_prevoir" value="" class="form-control">
                            </div>
                        </div>
                    </p>

                </div>

                <div style="overflow:auto;">
                    <div style="float:right;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
                        <button type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
                    </div>
                </div>
                <!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                </div>
                <!-- <input type="hidden" value="<?php echo $hdnid; ?>" name="repair_car" />
                <input type="hidden" name="hfInvoiceId" value="<?php echo $invoice_id; ?>" />
                <input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
                <input type="hidden" name="ddlMake" value="" />
                <input type="hidden" name="ddlModel" value="" />
                <input type="hidden" name="ddlImma" value="" /> -->
                <input type="hidden" name="add_car_id" value="<?php echo $_GET['add_car_id']; ?>" />
            </section>
        </form>
    </div>

    <script>
        var row = <?php echo $row; ?>;

        function addEstimate() {
            html = '<tr id="estimate-row' + row + '">';
            html += '  <td class="text-right"><input id="parts_desc_' + row + '" type="text" name="estimate_data[' + row + '][designation]" class="form-control" /></td>';
            // html += '  <td class="text-right"><input type="text" id="price_' + row + '" name="estimate_data[' + row + '][price]" value="0.00" class="form-control eFire allownumberonly" /></td>';
            html += '  <td class="text-right"><input id="qty_' + row + '" type="text" name="estimate_data[' + row + '][quantity]" value="0" class="form-control eFire allownumberonly" /></td>';
            // html += '  <td class="text-right"><input type="text" id="total_' + row + '" name="estimate_data[' + row + '][total]" value="0.00" class="form-control etotal allownumberonly" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#estimate-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            $('#labour_table tbody').append(html);
            row++;
            reloadQtyRow();
            numberAllow();
        }

        function addDataToEstimate(obj, parts_id, price, qty, warranty) {
            if (parseInt(qty) > 0) {
                var row = $("#estimate_row").val();
                var parts_name = $(obj).find(".parts_name").html();
                $("#parts_desc_" + row).val(parts_name);
                $("#price_" + row).val(price);
                $("#qty_" + row).val('1');
                $("#total_" + row).val(price);
                $("#parts_id_" + row).val(parts_id);
                $("#warranty_" + row).val(warranty);
                totalEstCost();
                $("#filter_popup").modal("hide")
            } else {
                alert("Le stock de la pièce est vide");
            }
        }

        $(document).ready(function() {
            reloadQtyRow();
        });

        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Valider";
            } else {
                document.getElementById("nextBtn").innerHTML = "Suivant";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>

</body>

</html>

<?php include('../footer.php'); ?>