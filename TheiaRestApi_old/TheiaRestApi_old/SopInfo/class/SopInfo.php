<?php
class SopInfo
{
    // Connection
    private $conn;
    // Table
    private $dbTable = "sop_info";
    // Columns
    private $sopId;
    private $patientId;
    private $studyId;
    private $seriesId;
    private $sopInstanceUid;
    private $imgId;
    private $updDtm;
    private $regDtm;
    private $delYn;

    // Getters and Setters
    public function setSopId($sopId)
    {
        $this->sopId = $sopId;
    }
    public function setPatientId($patientId)
    {
        $this->patientId = $patientId;
    }
    public function setStudyId($studyId)
    {
        $this->studyId = $studyId;
    }
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function setSopInstanceUid($sopInstanceUid)
    {
        $this->sopInstanceUid = $sopInstanceUid;
    }
    public function setImgId($imgId)
    {
        $this->imgId = $imgId;
    }
    public function setUpdDtm($updDtm)
    {
        $this->updDtm = $updDtm;
    }
    public function setRegDtm($regDtm)
    {
        $this->regDtm = $regDtm;
    }
    public function setDelYn($delYn)
    {
        $this->delYn = $delYn;
    }



    public function getSopId()
    {
        return $this->sopId;
    }
    public function getPatientId()
    {
        return $this->patientId;
    }
    public function getStudyId()
    {
        return $this->studyId;
    }
    public function getSeriesId()
    {
        return $this->seriesId;
    }
    public function getSopInstanceUid()
    {
        return $this->sopInstanceUid;
    }
    public function getImgId()
    {
        return $this->imgId;
    }
    public function getUpdDtm()
    {
        return $this->updDtm;
    }
    public function getRegDtm()
    {
        return $this->regDtm;
    }
    public function getDelYn()
    {
        return $this->delYn;
    }



    // DB Connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getSops()
    {
        $sql_query = "SELECT sop_id, patient_id, study_id, series_id, sop_instance_uid,
            img_id, upd_dtm, reg_dtm, del_yn FROM " . $this->dbTable . "";
        $stmt = $this->conn->prepare($sql_query);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createSops()
    {

        $sql_query = "INSERT INTO
                         " . $this->dbTable . "
                    SET 
                        sop_id = :sopId,                
                        patient_id = :patientId,
                        study_id = :studyId,
                        series_id = :seriesId,
                        sop_instance_uid = :sopInstanceUid,
                        img_id = :imgId, 
                        upd_dtm = :updDtm,
                        reg_dtm = :regDtm,
                        del_yn = :delYn";

        // $SQL_QUERY = "INSERT INTO " . $this->DB_TABLE . " VALUES($STUDY_ID, )"
        $stmt = $this->conn->prepare($sql_query);

        /// sanitize: removing any illegal character from the data.
        // strip_tags: removing HTML tags and PHP tags from string.
        // htmlspecialchars: converting specific 'special characters' into 'HTML entity' in string.
        $this->setSopId(htmlspecialchars(strip_tags($this->getSopId())));
        $this->setPatientId(htmlspecialchars(strip_tags($this->getPatientId())));
        $this->setStudyId(htmlspecialchars(strip_tags($this->getStudyId())));
        $this->setSeriesId(htmlspecialchars(strip_tags($this->getSeriesId())));
        $this->setSopInstanceUid(htmlspecialchars(strip_tags($this->getSopInstanceUid())));
        $this->setImgId(htmlspecialchars(strip_tags($this->getImgId())));
        $this->setUpdDtm(htmlspecialchars(strip_tags($this->getUpdDtm())));
        $this->setRegDtm(htmlspecialchars(strip_tags($this->getRegDtm())));
        $this->setDelYn(htmlspecialchars(strip_tags($this->getDelYn())));

        // bind data: the process of connecting and synchronizing data
        // between a PHP application and a database.
        $stmt->bindParam(":sopId", $this->sopId);
        $stmt->bindParam(":patientId", $this->patientId);
        $stmt->bindParam(":studyId", $this->studyId);
        $stmt->bindParam(":seriesId", $this->seriesId);
        $stmt->bindParam(":sopInstanceUid", $this->sopInstanceUid);
        $stmt->bindParam(":imgId", $this->imgId);
        $stmt->bindParam(":updDtm", $this->updDtm);
        $stmt->bindParam(":regDtm", $this->regDtm);
        $stmt->bindParam(":delYn", $this->delYn);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ single
    public function getSingleSop()
    {

        $sql_query = "SELECT
                          sop_id,
                          patient_id,
                          study_id,
                          series_id,
                          sop_instance_uid,
                          img_id,
                          upd_dtm,
                          reg_dtm,
                          del_yn
                          FROM
                         " . $this->dbTable . "
                         WHERE
                            patient_id = ?
                         LIMIT 0,1";

        $stmt = $this->conn->prepare($sql_query);
        $stmt->bindParam(1, $this->patientId);
        $stmt->execute();
        $datarow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->setSopId($datarow['sop_id']);
        $this->setPatientId($datarow['patient_id']);
        $this->setStudyId($datarow['study_id']);
        $this->setSeriesId($datarow['series_id']);
        $this->setSopInstanceUid($datarow['sop_instance_uid']);
        $this->setImgId($datarow['img_id']);
        $this->setUpdDtm($datarow['upd_dtm']);
        $this->setRegDtm($datarow['reg_dtm']);
        $this->setDelYn($datarow['del_yn']);
    }

    // UPDATE
    public function updateSop()
    {

        $sql_query = "UPDATE
                         " . $this->dbTable . "
                    SET
                          patient_id = :patientId,
                          study_id = :studyId,
                          series_id = :seriesId,
                          sop_instance_uid = :sopInstanceUid,
                          img_id = :imgId,
                          upd_dtm = :updDtm,
                          reg_dtm = :regDtm,
                          del_yn = :delYn
                    WHERE
                          sop_id = :sopId";

        $stmt = $this->conn->prepare($sql_query);


        /// sanitize: removing any illegal character from the data.
        // strip_tags: removing HTML tags and PHP tags from string.
        // htmlspecialchars: converting specific 'special characters' into 'HTML entity' in string.
        $this->setPatientId(htmlspecialchars(strip_tags($this->getPatientId())));
        $this->setStudyId(htmlspecialchars(strip_tags($this->getStudyId())));
        $this->setSeriesId(htmlspecialchars(strip_tags($this->getSeriesId())));
        $this->setSopInstanceUid(htmlspecialchars(strip_tags($this->getSopInstanceUid())));
        $this->setImgId(htmlspecialchars(strip_tags($this->getImgId())));
        $this->setUpdDtm(htmlspecialchars(strip_tags($this->getUpdDtm())));
        $this->setRegDtm(htmlspecialchars(strip_tags($this->getRegDtm())));
        $this->setDelYn(htmlspecialchars(strip_tags($this->getDelYn())));
        $this->setSopId(htmlspecialchars(strip_tags($this->getSopId())));

        // bind data: the process of connecting and synchronizing data
        // between a PHP application and a database.
        $stmt->bindParam(":patientId", $this->patientId);
        $stmt->bindParam(":studyId", $this->studyId);
        $stmt->bindParam(":seriesId", $this->seriesId);
        $stmt->bindParam(":sopInstanceUid", $this->sopInstanceUid);
        $stmt->bindParam(":imgId", $this->imgId);
        $stmt->bindParam(":updDtm", $this->updDtm);
        $stmt->bindParam(":regDtm", $this->regDtm);
        $stmt->bindParam(":delYn", $this->delYn);
        $stmt->bindParam(":sopId", $this->sopId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteSop()
    {

        $sql_query = "DELETE FROM " . $this->dbTable . " WHERE sop_id = ?";

        $stmt = $this->conn->prepare($sql_query);

        $this->setSopId(htmlspecialchars(strip_tags($this->getSopId())));

        $stmt->bindParam(1, $this->getSopId());

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }



}
?>