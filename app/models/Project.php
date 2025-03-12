<?php

require_once __DIR__ . '/Model.php';

class Project extends Model
{
    /** static data */
    public    static $table         = 'projects';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'project_name', 'status'];

    /** properties */
    protected $barangay_id  = 0;
    protected $project_name = '';
    protected $budget       = '';
    protected $status       = '';
    protected $start_date   = '';
    protected $end_date     = '';


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
     * Gets Project barangay_id.
     * @return int
     */
    public function getBarangayId()
    {
        return $this->barangay_id;
    }


    /**
     * Gets Project project_name.
     * @return string
     */
    public function getProjectName()
    {
        return $this->project_name;
    }


    /**
     * Gets Project budget.
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }


    /**
     * Gets Project status.
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Gets Project start_date.
     * @return string
     */
    public function getStartDate()
    {
        return $this->start_date;
    }


    /**
     * Gets Project end_date.
     * @return string
     */
    public function getEndDate()
    {
        return $this->end_date;
    }


    /**
     * Sets Project barangay_id.
     * @param $barangay_id
     * @return void
     */
    public function setBarangayId($barangay_id)
    {
        $this->barangay_id = $barangay_id;
    }


    /**
     * Sets Project project_name.
     * @param $project_name
     * @return void
     */
    public function setProjectName($project_name)
    {
        $this->project_name = $project_name;
    }


    /**
     * Sets Project budget.
     * @param $budget
     * @return void
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }


    /**
     * Sets Project status.
     * @param $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * Sets Project start_date.
     * @param $start_date
     * @return void
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }


    /**
     * Retrieves all Project records, optionally filtering by Barangay.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param Barangay|null $barangay
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?Barangay $barangay = null): array
    {
        $query = "SELECT * FROM `" . self::$table . "`";
        $params = [];
        $types = '';

        if ($barangay !== null) {
            $query .= " WHERE `barangay_id` = ?";
            $params[] = $barangay->getId();
            $types .= "i";
        }

        $stmt = self::getConnectionStatic()->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $projects = [];
        while ($row = $result->fetch_assoc()) {
            $project = new Project();
            $project->hydrate($row);
            $projects[] = $assoc ? $project->getAssoc($assoc_basic) : $project;
        }
        return $projects;
    }


    /**
     * Gets the parent Barangay for this Project.
     *
     * @return Barangay|null
     * @throws Exception
     */
    public function getBarangay(): ?Barangay
    {
        require_once __DIR__ . '/Barangay.php';
        return Barangay::find($this->barangay_id);
    }


    /**
     * Insert project
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`barangay_id`, `project_name`, `budget`, `status`, `start_date`, `end_date`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isisss", $this->barangay_id, $this->project_name, $this->budget, $this->status, $this->start_date, $this->end_date);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update project
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `barangay_id` = ?, `project_name` = ?, `budget` = ?, `status` = ?, `start_date` = ?, `end_date` = ? WHERE `id` = ?");
        $stmt->bind_param("isssssi", $this->barangay_id, $this->project_name, $this->budget, $this->status, $this->start_date, $this->end_date, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Delete project
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
}
