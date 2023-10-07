<?php
class SeriesInfo
{
    // Connection
    private $conn;
    // Table
    private $dbTable = "series_info";
    // Columns
    private $seriesId;
    private $patientId;
    private $studyId;
    private $seriesInstanceUid;
    private $updDtm;
    private $regDtm;
    private $delYn;

    // Getters and Setters
    public function setSeriesId($seriesId)
    {
        $this->seriesId = $seriesId;
    }
    public function setPatientId($patientId)
    {
        $this->patientId = $patientId;
    }
    public function setStudyId($studyId)
    {
        $this->studyId = $studyId;
    }
    public function setSeriesInstanceUid($seriesInstanceUid)
    {
        $this->seriesInstanceUid = $seriesInstanceUid;
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



    public function getSeriesId()
    {
        return $this->seriesId;
    }
    public function getPatientId()
    {
        return $this->patientId;
    }
    public function getStudyId()
    {
        return $this->studyId;
    }
    public function getSeriesInstanceUid()
    {
        return $this->seriesInstanceUid;
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
    public function getSeries()
    {
        $sqlQuery = "SELECT series_id, patient_id, study_id, series_instance_uid,
        upd_dtm, reg_dtm, del_yn FROM " . $this->dbTable . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createSeries()
    {

        $sqlQuery = "INSERT INTO
                         " . $this->dbTable . "
                    SET 
                        series_id = :seriesId,                
                        patient_id = :patientId,
                        study_id = :studyId,
                        series_instance_uid = :seriesInstanceUid,     
                        upd_dtm = :updDtm,
                        reg_dtm = :regDtm,
                        del_yn = :delYn";

        // $SQL_QUERY = "INSERT INTO " . $this->DB_TABLE . " VALUES($STUDY_ID, )"
        $stmt = $this->conn->prepare($sqlQuery);

        /// sanitize: removing any illegal character from the data.
        // strip_tags: removing HTML tags and PHP tags from string.
        // htmlspecialchars: converting specific 'special characters' into 'HTML entity' in string.
        $this->setSeriesId(htmlspecialchars(strip_tags($this->getSeriesId())));
        $this->setPatientId(htmlspecialchars(strip_tags($this->getPatientId())));
        $this->setStudyId(htmlspecialchars(strip_tags($this->getStudyId())));
        $this->setSeriesInstanceUid(htmlspecialchars(strip_tags($this->getSeriesInstanceUid())));
        $this->setUpdDtm(htmlspecialchars(strip_tags($this->getUpdDtm())));
        $this->setRegDtm(htmlspecialchars(strip_tags($this->getRegDtm())));
        $this->setDelYn(htmlspecialchars(strip_tags($this->getDelYn())));

        // bind data: the process of connecting and synchronizing data
        // between a PHP application and a database.
        $stmt->bindParam(":seriesId", $this->seriesId);
        $stmt->bindParam(":patientId", $this->patientId);
        $stmt->bindParam(":studyId", $this->studyId);
        $stmt->bindParam(":seriesInstanceUid", $this->seriesInstanceUid);
        $stmt->bindParam(":updDtm", $this->updDtm);
        $stmt->bindParam(":regDtm", $this->regDtm);
        $stmt->bindParam(":delYn", $this->delYn);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ single
    public function getSingleSeries()
    {

        $sqlQuery = "SELECT
                          series_id,
                          patient_id,
                          study_id,
                          series_instance_uid,
                          upd_utm,
                          reg_dtm,
                          del_yn
                          FROM
                         " . $this->dbTable . "
                         WHERE
                            patient_id = ?
                         LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->patientId);
        $stmt->execute();
        $datarow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->setSeriesId($datarow['series_id']);
        $this->setPatientId($datarow['patient_id']);
        $this->setStudyId($datarow['study_id']);
        $this->setSeriesInstanceUid($datarow['series_instance_uid']);
        $this->setUpdDtm($datarow['upd_dtm']);
        $this->setRegDtm($datarow['reg_dtm']);
        $this->setDelYn($datarow['del_yn']);
    }

    // UPDATE
    public function updateSeries()
    {

        $sqlQuery = "UPDATE
                         " . $this->dbTable . "
                    SET
                          patient_id = :patientId,
                          study_id = :studyId,
                          series_instance_uid = :seriesInstanceUid,
                          upd_dtm = :updDtm,
                          reg_dtm = :regDtm,
                          del_yn = :delYn
                    WHERE
                          series_id = :seriesId";

        $stmt = $this->conn->prepare($sqlQuery);


        /// sanitize: removing any illegal character from the data.
        // strip_tags: removing HTML tags and PHP tags from string.
        // htmlspecialchars: converting specific 'special characters' into 'HTML entity' in string.
        $this->setPatientId(htmlspecialchars(strip_tags($this->getPatientId())));
        $this->setStudyId(htmlspecialchars(strip_tags($this->getStudyId())));
        $this->setSeriesInstanceUid(htmlspecialchars(strip_tags($this->getSeriesInstanceUid())));
        $this->setUpdDtm(htmlspecialchars(strip_tags($this->getUpdDtm())));
        $this->setRegDtm(htmlspecialchars(strip_tags($this->getRegDtm())));
        $this->setDelYn(htmlspecialchars(strip_tags($this->getDelYn())));
        $this->setSeriesId(htmlspecialchars(strip_tags($this->getSeriesId())));

        // bind data: the process of connecting and synchronizing data
        // between a PHP application and a database.
        $stmt->bindParam(":patientId", $this->patientId);
        $stmt->bindParam(":studyId", $this->studyId);
        $stmt->bindParam(":seriesInstanceUid", $this->seriesInstanceUid);
        $stmt->bindParam(":updDtm", $this->updDtm);
        $stmt->bindParam(":regDtm", $this->regDtm);
        $stmt->bindParam(":delYn", $this->delYn);
        $stmt->bindParam(":seriesId", $this->seriesId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteSeries()
    {

        $sqlQuery = "DELETE FROM " . $this->dbTable . " WHERE series_id = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->setSeriesId(htmlspecialchars(strip_tags($this->getSeriesId())));

        $stmt->bindParam(1, $this->getSeriesId());

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }



}
?>