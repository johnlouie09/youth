<?php

require_once __DIR__ . '/Model.php';

class Announcement extends Model
{
    /** static data */
    public    static $table         = 'announcements';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'img', 'title', 'date', 'is_featured'];

    /** properties */
    protected $barangay_id = 0;
    protected $img         = '';
    protected $title       = '';
    protected $description = '';
    protected $date        = '';
    protected $is_featured = 0;


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
     * Gets Announcement title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /** Gets Announcement description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Gets Announcement date
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Gets Announcement is_featured
     * @return int
     */
    public function getIsFeatured()
    {
        return $this->is_featured;
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
     * Sets Announcement img.
     * @param $img
     * @return void
     */
    public function setImg($img)
    {
        $this->img = $img;
    }


    /**
     * Sets Announcement title
     * @param $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * Sets Announcement description
     * @param $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * Sets Announcement date
     * @param $date
     * @return void
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


    /**
     * Sets Announcement is_featured
     * @param $is_featured
     * @return void
     */
    public function setIsFeatured($is_featured)
    {
        $this->is_featured = $is_featured;
    }


    /**
     * Gets the announcement data as an associative array, with the 'img' field returned as an array of image filenames.
     *
     * @param bool $basic
     * @return array
     */
    public function getAssoc(bool $basic = false): array
    {
        $arr = parent::getAssoc($basic);

        // Convert the 'img' field to an array.
        if (!empty($arr['img'])) {
            $arr['img'] = array_map('trim', explode(',', $arr['img']));
        } else {
            $arr['img'] = [];
        }

        return $arr;
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
     * Retrieves a limited number of random Announcement records across all barangays.
     *
     * @param int $limit
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     * @throws Exception
     */
    public static function getRandomAnnouncements(int $limit = 50, bool $assoc = false, bool $assoc_basic = false): array
    {
        $conn = self::getConnectionStatic();
        $query = "SELECT * FROM `" . self::$table . "` ORDER BY RAND() LIMIT ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $limit);
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
        $query = "SELECT COUNT(*) AS count
                  FROM `" . self::$table . "` a
                  JOIN barangays b ON a.barangay_id = b.id
                  WHERE YEAR(a.created_at) = ? AND b.slug = ?";
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
     * Returns a summary of announcements per month and total announcements per year.
     * If a barangay slug is provided, the summary is generated only for that specific barangay.
     *
     * @param string|null $barangaySlug
     * @return array
     * @throws Exception
     */
    public static function getMonthlySummary(?string $barangaySlug = null): array
    {
        $conn = self::getConnectionStatic();

        // Monthly summary using the "date" column
        if ($barangaySlug !== null) {
            $queryMonthly = "SELECT YEAR(a.date) AS year, MONTHNAME(a.date) AS month, COUNT(*) AS count
                             FROM `" . self::$table . "` a
                             JOIN barangays b ON a.barangay_id = b.id
                             WHERE b.slug = ?
                             GROUP BY YEAR(a.date), MONTH(a.date)
                             ORDER BY YEAR(a.date) ASC, MONTH(a.date) ASC";
            $stmt = $conn->prepare($queryMonthly);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $barangaySlug);
        } else {
            $queryMonthly = "SELECT YEAR(date) AS year, MONTHNAME(date) AS month, COUNT(*) AS count
                             FROM `" . self::$table . "`
                             GROUP BY YEAR(date), MONTH(date)
                             ORDER BY YEAR(date) ASC, MONTH(date) ASC";
            $stmt = $conn->prepare($queryMonthly);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $monthlyGrouped = [];
        while ($row = $result->fetch_assoc()) {
            $year = $row['year'];
            if (!isset($monthlyGrouped[$year])) {
                $monthlyGrouped[$year] = [];
            }
            $monthlyGrouped[$year][] = [
                'month' => $row['month'],
                'count' => $row['count'],
            ];
        }

        // Annual summary using the "date" column
        if ($barangaySlug !== null) {
            $queryAnnual = "SELECT YEAR(a.date) AS year, COUNT(*) AS total
                            FROM `" . self::$table . "` a
                            JOIN barangays b ON a.barangay_id = b.id
                            WHERE b.slug = ?
                            GROUP BY YEAR(a.date)
                            ORDER BY year ASC";
            $stmt = $conn->prepare($queryAnnual);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $barangaySlug);
        } else {
            $queryAnnual = "SELECT YEAR(date) AS year, COUNT(*) AS total
                            FROM `" . self::$table . "`
                            GROUP BY YEAR(date)
                            ORDER BY year ASC";
            $stmt = $conn->prepare($queryAnnual);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $annual = [];
        while ($row = $result->fetch_assoc()) {
            $annual[] = $row;
        }

        return [
            'monthly' => $monthlyGrouped,
            'annual'  => $annual
        ];
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
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`barangay_id`, `img`, `title`, `description`, `date`, `is_featured`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssi", $this->barangay_id, $this->img, $this->title, $this->description, $this->is_featured);
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
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `barangay_id` = ?, `img` = ?, `title` = ?, `description` = ?, `date` = ?, `is_featured` = ? WHERE `id` = ?");
        $stmt->bind_param("issssii", $this->barangay_id, $this->img, $this->title, $this->description, $this->date, $this->is_featured, $this->id);
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
