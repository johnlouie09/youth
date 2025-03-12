<?php

require_once __DIR__ . '/Model.php';

class Cluster extends Model
{
    /** static data */
    public static $table = 'clusters';
    public static $table_columns = [];
    protected static $basic_columns = ['id', 'slug', 'name'];

    /** properties */
    protected $slug = '';
    protected $name = '';


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
     * Gets Cluster slug.
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Gets Cluster name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Sets Cluster slug.
     * @param $slug
     * @return void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }


    /**
     * Sets Cluster name.
     * @param $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * Get all Cluster.
     * @param $assoc
     * @param $assoc_basic
     * @return array
     */
    public static function all($assoc = false, $assoc_basic = false)
    {
        $clusters = [];

        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "`");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cluster = new Cluster();
                $cluster->hydrate($row);

                $clusters[] = $assoc ? $cluster->getAssoc($assoc_basic) : $cluster;
            }
        }

        return $clusters;
    }


    /**
     * Gets all Barangays that belong to this Cluster.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getBarangays(bool $assoc = false, bool $assoc_basic = false): array
    {
        return Barangay::all($assoc, $assoc_basic, $this);
    }


    /**
     * Insert cluster
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`slug`, `name`) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->slug, $this->name);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update cluster
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `slug` = ?, `name` = ? WHERE `id` = ?");
        $stmt->bind_param("ssi", $this->slug, $this->name, $this->id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }


    /**
     * Delete cluster
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
