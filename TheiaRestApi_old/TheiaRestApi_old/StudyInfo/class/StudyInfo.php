<?php
class StudyInfo
{
    // Connection
    private $conn;
    // Table
    private $dbTable = "study_info";
    // Columns
    private $studyId;
    private $patientId;
    private $studyDate;
    private $studyInstanceUid;
    private $updDtm;
    private $regDtm;
    private $delYn;

    // Getters and Setters
    public function setStudyId($studyId)
    {
        $this->studyId = $studyId;
    }
    public function setPatientId($patientId)
    {
        $this->patientId = $patientId;
    }
    public function setStudyDate($studyDate)
    {
        $this->studyDate = $studyDate;
    }
    public function setStudyInstanceUid($studyInstanceUid)
    {
        $this->studyInstanceUid = $studyInstanceUid;
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



    public function getStudyId()
    {
        return $this->studyId;
    }
    public function getPatientId()
    {
        return $this->patientId;
    }
    public function getStudyDate()
    {
        return $this->studyDate;
    }
    public function getStudyInstanceUid()
    {
        return $this->studyInstanceUid;
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
    public function getStudies()
    {
        $sqlQuery = "SELECT study_id, patient_id, study_date, study_instance_uid,
            upd_dtm, reg_dtm, del_yn FROM " . $this->dbTable . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createStudy()
    {

        $sqlQuery = "INSERT INTO
                         " . $this->dbTable . "
                    SET 
                        study_id = :studyId,                
                        patient_id = :patientId,
                        study_date = :studyDate,
                        study_instance_uid = :studyInstanceUid,     
                        upd_dtm = :updDtm,
                        reg_dtm = :regDtm,
                        del_yn = :delYn";

        // $SQL_QUERY = "INSERT INTO " . $this->DB_TABLE . " VALUES($STUDY_ID, )"
        $stmt = $this->conn->prepare($sqlQuery);

        /// sanitize: removing any illegal character from the data.
        // strip_tags: removing HTML tags and PHP tags from string.
        // htmlspecialchars: converting specific 'special characters' into 'HTML entity' in string.
        $this->setStudyId(htmlspecialchars(strip_tags($this->getStudyId())));
        $this->setPatientId(htmlspecialchars(strip_tags($this->getPatientId())));
        $this->setStudyDate(htmlspecialchars(strip_tags($this->getStudyDate())));
        $this->setStudyInstanceUid(htmlspecialchars(strip_tags($this->getStudyInstanceUid())));
        $this->setUpdDtm(htmlspecialchars(strip_tags($this->getUpdDtm())));
        $this->setRegDtm(htmlspecialchars(strip_tags($this->getRegDtm())));
        $this->setDelYn(htmlspecialchars(strip_tags($this->getDelYn())));

        // bind data: the process of connecting and synchronizing data
        // between a PHP application and a database.
        $stmt->bindParam(":studyId", $this->studyId);
        $stmt->bindParam(":patientId", $this->patientId);
        $stmt->bindParam(":studyDate", $this->studyDate);
        $stmt->bindParam(":studyInstanceUid", $this->studyInstanceUid);
        $stmt->bindParam(":updDtm", $this->updDtm);
        $stmt->bindParam(":regDtm", $this->regDtm);
        $stmt->bindParam(":delYn", $this->delYn);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ single
    public function getSingleStudy()
    {

        $sqlQuery = "SELECT
                          study_id,
                          patient_id,
                          study_date,
                          study_instance_uid,
                          upd_dtm,
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

        $this->setStudyId($datarow['study_id']);
        $this->setPatientId($datarow['patient_id']);
        $this->setStudyDate($datarow['study_date']);
        $this->setStudyInstanceUid($datarow['study_instance_uid']);
        $this->setUpdDtm($datarow['upd_dtm']);
        $this->setRegDtm($datarow['reg_dtm']);
        $this->setDelYn($datarow['del_yn']);
    }

    // UPDATE
    public function updateStudy()
    {

        $sqlQuery = "UPDATE
                         " . $this->dbTable . "
                    SET
                          patient_id = :patientId,
                          study_date = :studyDate,
                          study_instance_uid = :studyInstanceUid,
                          upd_dtm = :updDtm,
                          reg_dtm = :regDtm,
                          del_yn = :'N'
                    WHERE
                          study_id = :studyId";

        $stmt = $this->conn->prepare($sqlQuery);


        /// sanitize: removing any illegal character from the data.
        // strip_tags: removing HTML tags and PHP tags from string.
        // htmlspecialchars: converting specific 'special characters' into 'HTML entity' in string.
        $this->setPatientId(htmlspecialchars(strip_tags($this->getPatientId())));
        $this->setStudyDate(htmlspecialchars(strip_tags($this->getStudyDate())));
        $this->setStudyInstanceUid(htmlspecialchars(strip_tags($this->getStudyInstanceUid())));
        $this->setUpdDtm(htmlspecialchars(strip_tags($this->getUpdDtm())));
        $this->setRegDtm(htmlspecialchars(strip_tags($this->getRegDtm())));
        $this->setDelYn(htmlspecialchars(strip_tags($this->getDelYn())));
        $this->setStudyId(htmlspecialchars(strip_tags($this->getStudyId())));

        // bind data: the process of connecting and synchronizing data
        // between a PHP application and a database.
        $stmt->bindParam(":patientId", $this->patientId);
        $stmt->bindParam(":studyDate", $this->studyDate);
        $stmt->bindParam(":studyInstanceUid", $this->studyInstanceUid);
        $stmt->bindParam(":updDtm", $this->updDtm);
        $stmt->bindParam(":regDtm", $this->regDtm);
        $stmt->bindParam(":delYn", $this->delYn);
        $stmt->bindParam(":studyId", $this->studyId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteStudy()
    {

        $sqlQuery = "DELETE FROM " . $this->dbTable . " WHERE study_id = ?";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->setStudyId(htmlspecialchars(strip_tags($this->getStudyId())));

        $stmt->bindParam(1, $this->getStudyId());

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }



}
?>