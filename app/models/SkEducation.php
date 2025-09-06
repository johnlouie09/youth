<?php

require_once __DIR__ . '/Model.php';

class SkEducation extends Model
{
    protected static $table = 'sk_educations';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'educational_type', 'institution', 'institution_logo', 'course_or_details', 'educational_achievements', 'start_year', 'end_year'];

    /** properties */
    protected $sk_official_id               = 0;
    protected $educational_type             = '';
    protected $institution                  = '';
    protected $institution_logo             = '';
    protected $course_or_details            = '';
    protected $educational_achievements     = '';
    protected $start_year                   = 0;
    protected $end_year                     = 0;


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
     * Gets SkEducation educational_type.
     * @return string
     */
    public function getEducationalType()
    {
        return $this->educational_type;
    }

    /**
     * Gets SkEducation school_name.
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }


    /**
     * Gets SkEducation institution_logo
     * @return string
     */
    public function getInstitutionLogo()
    {
        return $this->institution_logo;
    }


    /**
     * Gets SkEducation course.
     * @return string
     */
    public function getCourseOrDetails()
    {
        return $this->course_or_details;
    }

    /**
     * Gets SkEducation Educational Achievements.
     * @return string
     */
    public function getEducationalAchievements()
    {
        return $this->educational_achievements;
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
     * Sets SkEducation educational_type.
     * @param $educational_type
     * @return void
     */
    public function setEducationalType($educational_type)
    {
        $this->educational_type = $educational_type;
    }

    /**
     * Sets SkEducation institution.
     * @param $institution
     * @return void
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
    }


    /**
     * Sets SkEducation institution_logo
     * @param $institution_logo
     * @return void
     */
    public function setInstitutionLogo($institution_logo)
    {
        $this->institution_logo = $institution_logo;
    }

    /**
     * Sets SkEducation course_or_details.
     * @param $course_or_details
     * @return void
     */
    public function setCourseOrDetails($course_or_details)
    {
        $this->course_or_details = $course_or_details;
    }

    /**
     * Sets SkEducation Educational Achievements.
     * @param $educational_achievements
     * @return void
     */
    public function setEducationalAchievements($educational_achievements)
    {
        $this->educational_achievements = $educational_achievements;
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
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return SkOfficial|array|null
     * @throws Exception
     */
    public function getSkOfficial(bool $assoc = false, bool $assoc_basic = false): array|SkOfficial|null
    {
        require_once __DIR__ . '/SkOfficial.php';
        $skOfficial = SkOfficial::find($this->sk_official_id);
        return ($assoc && $skOfficial) ? $skOfficial->getAssoc($assoc_basic) : $skOfficial;
    }


    /**
     * Insert sk_education
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "` 
            (`sk_official_id`, `educational_type`, `institution`, `institution_logo`, `course_or_details`, `educational_achievements`, `start_year`, `end_year`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param(
            "isssssii", 
            $this->sk_official_id, 
            $this->educational_type, 
            $this->institution, 
            $this->institution_logo, 
            $this->course_or_details, 
            $this->educational_achievements, 
            $this->start_year, 
            $this->end_year
        );

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
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `sk_official_id` = ?, `educational_type` = ?, `institution` = ?, `institution_logo` = ?, `course_or_details` = ?, `educational_achievements` = ?, `start_year` = ?, `end_year` = ? WHERE `id` = ?");
        $stmt->bind_param("isssssiii", $this->sk_official_id, $this->educational_type, $this->institution, $this->institution_logo, $this->course_or_details, $this->educational_achievements, $this->start_year, $this->end_year, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
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
        return $stmt->affected_rows > 0;
    }


    public static function fetchEducationTypes(): array
    {
        $stmt = self::getConnectionStatic()->prepare(
            "SHOW COLUMNS FROM `" . self::$table . "` LIKE 'educational_type'"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $educationTypes = [];
        if ($row && isset($row['Type'])) {
            // Extract ENUM values: enum('Primary','Secondary','Tertiary')
            preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
            if (!empty($matches[1])) {
                $educationTypes = array_filter(array_map(function ($val) {
                    return trim($val, " '");
                }, explode(",", $matches[1])), function ($v) {
                    return $v !== ''; // remove empty strings
                });
                $educationTypes = array_values($educationTypes); // reindex cleanly
            }
        }

        return $educationTypes;
    }



}
