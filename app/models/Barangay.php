<?php

require_once __DIR__ . '/Model.php';

class Barangay extends Model
{
    /** static data */
    public    static $table         = 'barangays';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'slug', 'name'];

    /** properties */
    protected $cluster_id   = 0;
    protected $slug         = '';
    protected $name         = '';


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
     * Gets Barangay cluster_id.
     * @return int
     */
    public function getClusterId()
    {
        return $this->cluster_id;
    }


    /**
     * Gets Barangay slug.
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Gets Barangay name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Sets Barangay cluster_id.
     * @param $cluster_id
     * @return void
     */
    public function setClusterId($cluster_id)
    {
        $this->cluster_id = $cluster_id;
    }


    /**
     * Sets Barangay slug.
     * @param $slug
     * @return void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }


    /**
     * Sets Barangay name.
     * @param $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * Get all Barangay.
     * @param $assoc
     * @param $assoc_basic
     * @return array
     */
    public static function all($assoc = false, $assoc_basic = false)
    {
        $barangays = [];

        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "`");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $barangay = new Barangay();
                $barangay->hydrate($row);

                $barangays[] = $assoc ? $barangay->getAssoc($assoc_basic) : $barangay;
            }
        }

        return $barangays;
    }


    /**
     * Insert barangay
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`cluster_id`, `slug`, `name`) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $this->cluster_id, $this->slug, $this->name);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update barangay
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `cluster_id` = ?, `slug` = ?, `name` = ? WHERE `id` = ?");
        $stmt->bind_param("issi", $this->cluster_id, $this->slug, $this->name, $this->id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }


    /**
     * Delete barangay
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
