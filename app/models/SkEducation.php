<?php

require_once __DIR__ . '/Model.php';

class SkEducation extends Model
{
    protected static $table = 'sk_educations';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'school_name', 'course', 'start_year', 'end_year'];

    /** properties */
    protected $sk_official_id     = 0;
    protected $education_level_id = 0;
    protected $school_name        = '';
    protected $course             = '';
    protected $start_year         = 0;
    protected $end_year           = 0;


    /**
     * Constructor
     * @param $id
     */
    public function __construct($id = 0)
    {
        parent::__construct();

        if ($id > 0) {
            $stmt = $this->getConnection()->prepare("SELECT * FROM `" . self::$table . "` WHERE `id` = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->hydrate($row);
            }
        }
    }


    /**
     * Gets SkEducation sk_official_id.
     * @return int
     */
    public function getSkOfficialId()
    {
        return $this->sk_official_id;
    }


    /**
     * Gets SkEducation education_level_id.
     * @return int
     */
    public function getEducationLevelId()
    {
        return $this->education_level_id;
    }


    /**
     * Gets SkEducation school_name.
     * @return string
     */
    public function getSchoolName()
    {
        return $this->school_name;
    }


    /**
     * Gets SkEducation course.
     * @return string
     */
    public function getCourse()
    {
        return $this->course;
    }


    /**
     * Gets SkEducation start_year.
     * @return int
     */
    public function getStartYear()
    {
        return $this->start_year;
    }


    /**
     * Gets SkEducation end_year.
     * @return int
     */
    public function getEndYear()
    {
        return $this->end_year;
    }


    /**
     * Sets SkEducation sk_official_id.
     * @param $sk_official_id
     * @return void
     */
    public function setSkOfficialId($sk_official_id)
    {
        $this->sk_official_id = $sk_official_id;
    }


    /**
     * Sets SkEducation education_level_id.
     * @param $education_level_id
     * @return void
     */
    public function setEducationLevelId($education_level_id)
    {
        $this->education_level_id = $education_level_id;
    }


    /**
     * Sets SkEducation school_name.
     * @param $school_name
     * @return void
     */
    public function setSchoolName($school_name)
    {
        $this->school_name = $school_name;
    }


    /**
     * Sets SkEducation course.
     * @param $course
     * @return void
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }


    /**
     * Sets SkEducation start_year.
     * @param $start_year
     * @return void
     */
    public function setStartYear($start_year)
    {
        $this->start_year = $start_year;
    }


    /**
     * Sets SkEducation end_year.
     * @param $end_year
     * @return void
     */
    public function setEndYear($end_year)
    {
        $this->end_year = $end_year;
    }


    /**
     * Retrieves all SK Education records, optionally filtering by SK Official.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param SkOfficial|null $skOfficial
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?SkOfficial $skOfficial = null): array
    {
        $query = "SELECT * FROM `" . self::$table . "`";
        $params = [];
        $types = '';

        if ($skOfficial !== null) {
            $query .= " WHERE `sk_official_id` = ?";
            $params[] = $skOfficial->getId();
            $types .= "i";
        }

        $stmt = self::getConnectionStatic()->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $educations = [];
        while ($row = $result->fetch_assoc()) {
            $education = new SkEducation();
            $education->hydrate($row);
            $educations[] = $assoc ? $education->getAssoc($assoc_basic) : $education;
        }
        return $educations;
    }


    /**
     * Gets the SK Official associated with this education record.
     *
     * @return SkOfficial|null
     * @throws Exception
     */
    public function getSkOfficial(): ?SkOfficial
    {
        return SkOfficial::find($this->sk_official_id);
    }


    /**
     * Insert sk_education
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`sk_official_id`, `education_level_id`, `school_name`, `course`, `start_year`, `end_year`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissii", $this->sk_official_id, $this->education_level_id, $this->school_name, $this->course, $this->start_year, $this->end_year);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update sk_education
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `sk_official_id` = ?, `education_level_id` = ?, `school_name` = ?, `course` = ?, `start_year` = ?, `end_year` = ? WHERE `id` = ?");
        $stmt->bind_param("iissiii", $this->sk_official_id, $this->education_level_id, $this->school_name, $this->course, $this->start_year, $this->end_year, $this->id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }


    /**
     * Delete sk_education
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
}
