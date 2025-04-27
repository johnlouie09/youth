<?php

require_once __DIR__ . '/Model.php';

class EducationLevel extends Model
{
    /** static data */
    public    static $table         = 'education_levels';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'name', 'description', 'sort_order'];

    /** properties */
    protected $name        = '';
    protected $description = '';
    protected $sort_order  = '';


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
     * Gets EducationLevel name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Gets EducationLevel description.
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Gets EducationLevel sort_order.
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }


    /**
     * Sets EducationLevel name.
     * @param $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * Sets EducationLevel description.
     * @param $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Sets EducationLevel sort_order.
     * @param $sort_order
     */
    public function setSortOrder($sort_order)
    {
        $this->sort_order = $sort_order;
    }

    /**
     * Get all EducationLevel.
     * @param $assoc
     * @param $assoc_basic
     * @return array
     */
    public static function all($assoc = false, $assoc_basic = false)
    {
        $education_levels = [];

        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "`");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $education_level = new EducationLevel();
                $education_level->hydrate($row);

                $education_levels[] = $assoc ? $education_level->getAssoc($assoc_basic) : $education_level;
            }
        }

        return $education_levels;
    }

    /**
     * Insert EducationLevel.
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`name`, `description`, `sort_order`) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $this->name, $this->description, $this->sort_order);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }

    /**
     * Update EducationLevel.
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `name` = ?, `description` = ?, `sort_order` = ? WHERE `id` = ?");
        $stmt->bind_param("ssii", $this->name, $this->description, $this->sort_order, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Delete EducationLevel.
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
