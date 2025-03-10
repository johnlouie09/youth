<?php

require_once __DIR__ . '/Model.php';

class Barangay extends Model
{
    /** static data */
    protected static $table         = 'barangays';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'cluster_id', 'name'];

    /** properties */
    protected $cluster_id   = 0;
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
}