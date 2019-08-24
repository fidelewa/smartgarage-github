<?php
include("../config.php");

// var_dump($_FILES);
// die();

if (isset($_FILES) && !empty($_FILES)) { //Si les données ont été soumis à partir du formulaire

    // Définition des fonctions d'enregistrement des photos des véhicules sur le serveur

    function upload_Img_1_car_av_work()
    {
        if ((!empty($_FILES["img_1_car_av_work"])) && ($_FILES['img_1_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_1_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_1_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_1_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_1_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_1_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_1_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_2_car_av_work()
    {
        if ((!empty($_FILES["img_2_car_av_work"])) && ($_FILES['img_2_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_2_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_2_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_2_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_2_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_2_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_2_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_3_car_av_work()
    {
        if ((!empty($_FILES["img_3_car_av_work"])) && ($_FILES['img_3_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_3_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_3_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_3_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_3_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_3_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_4_car_av_work()
    {
        if ((!empty($_FILES["img_4_car_av_work"])) && ($_FILES['img_4_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_4_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_4_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_4_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_4_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_4_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_5_car_av_work()
    {
        if ((!empty($_FILES["img_5_car_av_work"])) && ($_FILES['img_5_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_5_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_5_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_5_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_5_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_5_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_6_car_av_work()
    {
        if ((!empty($_FILES["img_6_car_av_work"])) && ($_FILES['img_6_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_6_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_6_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_6_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_6_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_6_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_7_car_av_work()
    {
        if ((!empty($_FILES["img_7_car_av_work"])) && ($_FILES['img_7_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_7_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_7_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_7_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_7_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_7_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_8_car_av_work()
    {
        if ((!empty($_FILES["img_8_car_av_work"])) && ($_FILES['img_8_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_8_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_8_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_8_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_8_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_8_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_9_car_av_work()
    {
        if ((!empty($_FILES["img_9_car_av_work"])) && ($_FILES['img_9_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_9_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_9_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_3_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_9_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_9_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_10_car_av_work()
    {
        if ((!empty($_FILES["img_10_car_av_work"])) && ($_FILES['img_10_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_10_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_10_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_10_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_10_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_10_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_11_car_av_work()
    {
        if ((!empty($_FILES["img_11_car_av_work"])) && ($_FILES['img_11_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_11_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_11_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_11_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_11_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_11_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    function upload_Img_12_car_av_work()
    {
        if ((!empty($_FILES["img_12_car_av_work"])) && ($_FILES['img_12_car_av_work']['error'] == 0)) {
            $filename = basename($_FILES['img_12_car_av_work']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            if ((($ext == "jpg" || $ext == "JPG") && $_FILES["img_12_car_av_work"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["img_12_car_av_work"]["type"] == 'image/png')
                || (($ext == "gif" || $ext == "GIF") && $_FILES["img_12_car_av_work"]["type"] == 'image/gif')
            ) {
                // $temp = explode(".", $_FILES["img_3_car_av_work"]["name"]);
                // $filename = NewGuid() . '.' . end($temp);
                move_uploaded_file($_FILES["img_12_car_av_work"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
                return $filename;
            } else {
                return '';
            }
        }
        return '';
    }

    // Récupération des URL des images
    if ((!empty($_FILES["img_1_car_av_work"])) && ($_FILES['img_1_car_av_work']['error'] == 0)) {
        $_POST['img_1_car_av_work'] = upload_Img_1_car_av_work();
    } else {
        $_POST['img_1_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_2_car_av_work"])) && ($_FILES['img_2_car_av_work']['error'] == 0)) {
        $_POST['img_2_car_av_work'] = upload_Img_2_car_av_work();
    } else {
        $_POST['img_2_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_3_car_av_work"])) && ($_FILES['img_3_car_av_work']['error'] == 0)) {
        $_POST['img_3_car_av_work'] = upload_Img_3_car_av_work();
    } else {
        $_POST['img_3_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_4_car_av_work"])) && ($_FILES['img_4_car_av_work']['error'] == 0)) {
        $_POST['img_4_car_av_work'] = upload_Img_4_car_av_work();
    } else {
        $_POST['img_4_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_5_car_av_work"])) && ($_FILES['img_5_car_av_work']['error'] == 0)) {
        $_POST['img_5_car_av_work'] = upload_Img_5_car_av_work();
    } else {
        $_POST['img_5_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_6_car_av_work"])) && ($_FILES['img_6_car_av_work']['error'] == 0)) {
        $_POST['img_6_car_av_work'] = upload_Img_6_car_av_work();
    } else {
        $_POST['img_6_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_7_car_av_work"])) && ($_FILES['img_7_car_av_work']['error'] == 0)) {
        $_POST['img_7_car_av_work'] = upload_Img_7_car_av_work();
    } else {
        $_POST['img_7_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_8_car_av_work"])) && ($_FILES['img_8_car_av_work']['error'] == 0)) {
        $_POST['img_8_car_av_work'] = upload_Img_8_car_av_work();
    } else {
        $_POST['img_8_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_9_car_av_work"])) && ($_FILES['img_9_car_av_work']['error'] == 0)) {
        $_POST['img_9_car_av_work'] = upload_Img_9_car_av_work();
    } else {
        $_POST['img_9_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_10_car_av_work"])) && ($_FILES['img_10_car_av_work']['error'] == 0)) {
        $_POST['img_10_car_av_work'] = upload_Img_10_car_av_work();
    } else {
        $_POST['img_10_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_11_car_av_work"])) && ($_FILES['img_11_car_av_work']['error'] == 0)) {
        $_POST['img_11_car_av_work'] = upload_Img_11_car_av_work();
    } else {
        $_POST['img_11_car_av_work'] = null;
    }

    if ((!empty($_FILES["img_12_car_av_work"])) && ($_FILES['img_12_car_av_work']['error'] == 0)) {
        $_POST['img_12_car_av_work'] = upload_Img_12_car_av_work();
    } else {
        $_POST['img_12_car_av_work'] = null;
    }

    // Recherche dans la table, d'un enregistrement portant les données sur lesquelles portent la condition
    $queryGetPhotoCarAvantWork = "SELECT * FROM tbl_photo_car_avant_work
        WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
        ";

    $resultGetPhotoCarAvantWork = mysql_query($queryGetPhotoCarAvantWork, $link);

    // if (!$resultGetPhotoCarAvantWork) {
    //     $message  = 'Invalid query: ' . mysql_error() . "\n";
    //     $message .= 'Whole query: ' . $queryGetPhotoCarAvantWork;
    //     die($message);
    // }

    $rowPhotoCarAvantWork = mysql_fetch_assoc($resultGetPhotoCarAvantWork);

    // Si aucun enregistrement ne correspond à la recherche, on fait une insertion
    if (empty($rowPhotoCarAvantWork) || $rowPhotoCarAvantWork == false) {

        // Insertion du nom de la marque dans la table des marques
        $query = "INSERT INTO tbl_photo_car_avant_work (img_1_url, img_2_url, img_3_url, img_4_url, img_5_url, img_6_url,
    img_7_url, img_8_url, img_9_url, img_10_url, img_11_url, img_12_url, car_id, car_recep_id
    ) VALUES('$_POST[img_1_car_av_work]','$_POST[img_2_car_av_work]','$_POST[img_3_car_av_work]',
    '$_POST[img_4_car_av_work]','$_POST[img_5_car_av_work]','$_POST[img_6_car_av_work]',
    '$_POST[img_7_car_av_work]','$_POST[img_8_car_av_work]','$_POST[img_9_car_av_work]',
    '$_POST[img_10_car_av_work]','$_POST[img_11_car_av_work]','$_POST[img_12_car_av_work]',
    '$_POST[car_id]','$_POST[car_recep_id]')";

        // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
        $result = mysql_query($query, $link);

        // if (!$result) {
        //     $message  = 'Invalid query: ' . mysql_error() . "\n";
        //     $message .= 'Whole query: ' . $query;
        //     die($message);
        // }

    } else { // Sinon on fait une mise à jour

        // On parcours la liste des images
        foreach ($_FILES as $key => $img_car_av_work) {

            // Si nous sommes à la première image et que le nom de l'image existe
            // alors on fait une mise à jour de la 1ère image dans la table

            // 1ERE IMAGE
            if ($key == "img_1_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_1_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 2EME IMAGE
            if ($key == "img_2_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_2_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 3EME IMAGE
            if ($key == "img_3_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_3_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 4EME IMAGE
            if ($key == "img_4_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_4_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 5EME IMAGE
            if ($key == "img_5_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_5_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 6EME IMAGE
            if ($key == "img_6_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_6_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 7EME IMAGE
            if ($key == "img_7_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_7_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 8EME IMAGE
            if ($key == "img_8_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_8_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 9EME IMAGE
            if ($key == "img_9_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_9_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 10EME IMAGE
            if ($key == "img_10_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_10_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 11EME IMAGE
            if ($key == "img_11_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_11_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }

            // 12EME IMAGE
            if ($key == "img_12_car_av_work" && $img_car_av_work["name"] != "") {
                $query = "UPDATE tbl_photo_car_avant_work
				SET `img_12_url`='" . $img_car_av_work["name"] . "'
                WHERE car_recep_id='" . $_POST['car_recep_id'] . "' AND car_id='" . $_POST['car_id'] . "'
                ";
                $result = mysql_query($query, $link);

                // if (!$result) {
                //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                //     $message .= 'Whole query: ' . $query;
                //     die($message);
                // }
            }
        }

    }

    // On fait une redirection
    if ((int) $_POST['photo_car_avant_work_id'] > 0) {
        echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "repaircar/photo_car_avant_work.php?car_recep_id=" . $_POST['car_recep_id'] . "&car_id=" . $_POST['car_id'] . "&m=up_photo_car_avant_work'</script>";
    } else {
        echo "<script type='text/javascript'> document.location.href='" . WEB_URL . "repaircar/photo_car_avant_work.php?car_recep_id=" . $_POST['car_recep_id'] . "&car_id=" . $_POST['car_id'] . "&m=add_photo_car_avant_work'</script>";
    }
    
}
