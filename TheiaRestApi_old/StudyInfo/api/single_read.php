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

    $item->setPatientId($_GET['patient_id']);
    
    $item->getSingleStudy();

    if($item->getPatientId() != null){
        // create array
        $stdArr = array(
            "studyId" => $item->getStudyId(),
            "patientId" => $item->getPatientId(),
            "studyDate" => $item->getStudyDate(),
            "studyInstanceUid" => $item->getStudyInstanceUid(),
            "updDtm" => $item->getUpdDtm(),
            "regDtm" => $item->getRegDtm(),
            "delYn" => $item->getDelYn()
        );

        http_response_code(200);
        echo json_encode($stdArr);
    }

    else{
        http_response_code(404);
        echo json_encode("Study not found.");
    }

?>


