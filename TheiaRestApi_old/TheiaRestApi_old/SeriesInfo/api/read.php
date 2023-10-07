<?php
    // when a site tries to fetch content from another site,
    // this header specifies where the content of a page is accessible.
    header("Access-Control-Allow-Origin: *");
    // designates the content to be in JSON format, encoded in the UTF-8.
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/DBConnect.php';
    include_once '../class/SeriesInfo.php';
    $database = new DBConnect();
    $db = $database->getConnection();
    $items = new SeriesInfo($db);
    $stmt = $items->getSeries();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);
    if($itemCount > 0) {

        $studyInfoArr = array();
        $studyInfoArr["body"] = array();
        $studyInfoArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // PDO::FETCH_ASSOC -> 결과 set에 반환된대로 열 이름으로 indexed된 배열을 반환함.
            extract($row);
            $e = array(
                "seriesId" => $row["series_id"],
                "patientId" => $row["patient_id"],
                "studyId" => $row["study_id"],
                "seriesInstanceUid" => $row["series_instance_uid"],
                "updDtm" => $row["upd_dtm"],
                "regDtm" => $row["reg_dtm"],
                "delYn" => $row["del_yn"]
            );
            array_push($study_info_arr["body"], $e);
        }
        echo json_encode($study_info_arr);
    }
    else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>

