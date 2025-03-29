<?php

require_once __DIR__ . '/Model.php';

class Announcement extends Model
{
    /** static data */
    public    static $table         = 'announcements';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'img'];

    /** properties */
    protected $barangay_id = 0;
    protected $img        = '';


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
     * Gets Announcement barangay_id.
     * @return int
     */
    public function getBarangayId()
    {
        return $this->barangay_id;
    }


    /**
     * Gets Announcement img.
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }


    /**
     * Sets Announcement barangay_id.
     * @param $barangay_id
     * @return void
     */
    public function setBarangayId($barangay_id)
    {
        $this->barangay_id = $barangay_id;
    }


    /**
     * Sets Barangay img.
     * @param $img
     * @return void
     */
    public function setImg($img)
    {
        $this->img = $img;
    }


    /**
     * Retrieves all Announcement records, optionally filtering by Barangay.
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
        $announcements = [];

        while ($row = $result->fetch_assoc()) {
            $announcement = new Announcement();
            $announcement->hydrate($row);
            $announcements[] = $assoc ? $announcement->getAssoc($assoc_basic) : $announcement;
        }

        return $announcements;
    }


    /**
     * Returns the count of announcements made in a given year for a specific barangay.
     *
     * @param string $barangaySlug
     * @param int $year
     * @return int
     * @throws Exception
     */
    public static function getAnnualCount(string $barangaySlug, int $year): int
    {
        $conn = self::getConnectionStatic();
        $query = "
        SELECT COUNT(*) AS count
        FROM `" . self::$table . "` a
        JOIN barangays b ON a.barangay_id = b.id
        WHERE YEAR(a.created_at) = ? AND b.slug = ?
    ";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("is", $year, $barangaySlug);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int)$row['count'];
    }


    /**
     * Gets the Barangay that this Announcement belongs to.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return Barangay|array|null
     * @throws Exception
     */
    public function getBarangay(bool $assoc = false, bool $assoc_basic = false): Barangay|array|null
    {
        require_once __DIR__ . '/Barangay.php';
        $barangay = Barangay::find($this->barangay_id);
        return ($assoc && $barangay) ? $barangay->getAssoc($assoc_basic) : $barangay;
    }


    /**
     * Insert announcement
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`barangay_id`, `img`) VALUES (?, ?)");
        $stmt->bind_param("is", $this->barangay_id, $this->img);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update announcement
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `barangay_id` = ?, `img` = ? WHERE `id` = ?");
        $stmt->bind_param("isi", $this->barangay_id, $this->img, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Delete announcement
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
