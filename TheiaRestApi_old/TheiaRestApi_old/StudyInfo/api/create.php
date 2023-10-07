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
    include_once '../class/StudyInfo.php';


    $database = new DBConnect();
    $db = $database->getConnection();
    $item = new StudyInfo($db); 


    $item->setPatientId($_POST['patient_id']);
    $item->setStudyDate($_POST['study_date']);
    $item->setStudyInstanceUid($_POST['study_instance_uid']);
    $item->setUpdDtm($_POST['upd_utm']);
    $item->setRegDtm($_POST['reg_dtm']);
    $item->setDelYn($_POST['del_yn']);

    
    if($item->createStudy()){
        echo 'Study created successfully.';
    } else{
        echo 'Study could not be created.';
    }


?>


