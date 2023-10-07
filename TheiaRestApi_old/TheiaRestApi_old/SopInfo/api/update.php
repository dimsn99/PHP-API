<?php
    // when a site tries to fetch content from another site,
    // this header specifies where the content of a page is accessible.
    header("Access-Control-Allow-Origin: *");
    // designates the content to be in JSON format, encoded in the UTF-8.
    header("Content-Type: application/json; charset=UTF-8");
    // a header request that allows one or more HTTP methods when accessing
    // a resource when responding to a preflight request.
    header("Access-Control-Allow-Methods: POST");
    // a header request that determines how long to cache the results of a preflight request.
    header("Access-Control-Max-Age: 3600");
    // to indicate which HTTP headers can be used during the actual request.
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/DBConnect.php';
    include_once '../class/SopInfo.php';

    $database = new DBConnect();
    $db = $database->getConnection();

    $item = new SopInfo($db);


    $item->setSopId($_GET['sop_id']);

    // patient values
    $item->setPatientId($_POST['patient_id']);
    $item->setStudyId($_POST['study_id']);
    $item->setSeriesId($_POST['series_id']);
    $item->setSopInstanceUid($_POST['sop_instance_uid']);
    $item->setImgId($_POST['img_id']);
    $item->setUpdDtm($_POST['upd_dtm']);
    $item->setRegDtm($_POST['reg_dtm']);
    $item->setDelYn($_POST['del_yn']);


    if($item->updateSop()){
        echo json_encode("Sop data updated.");
    } else{
        echo json_encode("Data could not be updated.");
    }
?>

