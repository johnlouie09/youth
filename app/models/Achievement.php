<?php

require_once __DIR__ . '/Model.php';

class Achievement extends Model
{
    /** static data */
    public    static $table         = 'achievements';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'title', 'subtitle','info', 'date'];

    /** properties */
    protected $sk_official_id   = 0;
    protected $sk_official_name = '';
    protected $title            = '';
    protected $subtitle         = '';
    protected $info             = '';
    protected $img              = '';
    protected $date             = '';


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
     * Gets Achievement sk_official_id.
     * @return int
     */
    public function getSkOfficialId()
    {
        return $this->sk_official_id;
    }


    /** Gets Achievement sk_official_name
     * @return string
     */
    public function getSkOfficialName()
    {
        return $this->sk_official_name;
    }


    /**
     * Gets Achievement title.
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Gets Achievement subtitle.
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }


    /**
     * Gets Achievement info.
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }


    /**
     * Gets Achievement img.
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }


    /**
     * Gets Achievement date.
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Sets Achievement sk_official_id.
     * @param $sk_official_id
     * @return void
     */
    public function setSkOfficialId($sk_official_id)
    {
        $this->sk_official_id = $sk_official_id;
    }


    /**
     * Sets Achievement sk_official_name.
     * @param $sk_official_name
     * @return void
     */
    public function setSkOfficialName($sk_official_name)
    {
        $this->sk_official_name = $sk_official_name;
    }


    /**
     * Sets Achievement title.
     * @param $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * Sets Achievement subtitle.
     * @param $subtitle
     * @return void
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }


    /**
     * Sets Achievement info.
     * @param $info
     * @return void
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }


    /**
     * Sets Achievement img.
     * @param $img
     * @return void
     */
    public function setImg($img)
    {
        $this->img = $img;
    }


    /**
     * Sets Achievement date.
     * @param $date
     * @return void
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


    /**
     * Override getAssoc() to include sk_official_name.
     *
     * @param bool $basic
     * @return array
     */
    public function getAssoc(bool $basic = false): array
    {
        // first, call the parent method to get the base associative array
        $arr = parent::getAssoc($basic);

        // then, add this field to include sk_official_name
        $arr['sk_official_name'] = $this->getSkOfficialName();

        return $arr;
    }


    /**
     * Retrieves all Achievement records, optionally filtering by SK Official.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param SkOfficial|null $skOfficial
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?SkOfficial $skOfficial = null): array
    {
        // join achievements (a) with sk_officials (s) to get the official's full_name
        $query = "SELECT a.*,
                      s.full_name AS sk_official_name
                  FROM achievements a
                  JOIN sk_officials s ON a.sk_official_id = s.id";
        $params = [];
        $types = "";

        if ($skOfficial !== null) {
            $query .= " WHERE a.sk_official_id = ?";
            $params[] = $skOfficial->getId();
            $types = "i";
        }

        $stmt = self::getConnectionStatic()->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $achievements = [];
        while ($row = $result->fetch_assoc()) {
            $achievement = new Achievement();
            $row['sk_official_name'] = $row['sk_official_name'] ?? '';
            $achievement->hydrate($row); // this calls setSkOfficialName internally
            $achievements[] = $assoc ? $achievement->getAssoc($assoc_basic) : $achievement;
        }
        return $achievements;
    }


    /**
     * Returns a summary of achievements per month and total achievements per year.
     * If a barangay slug is provided, the summary is generated only for that specific barangay.
     *
     * @param string|null $barangaySlug
     * @return array
     * @throws Exception
     */
    public static function getMonthlySummary(?string $barangaySlug = null): array
    {
        $conn = self::getConnectionStatic();

        if ($barangaySlug !== null) {
            // When filtering by barangay, join with the barangays table and filter by slug
            $queryMonthly = "
            SELECT YEAR(a.date) AS year, MONTHNAME(a.date) AS month, COUNT(*) AS count
            FROM `" . self::$table . "` a
            JOIN barangays b ON a.sk_official_id IN (
                SELECT id FROM sk_officials WHERE barangay_id = b.id
            )
            WHERE b.slug = ?
            GROUP BY YEAR(a.date), MONTH(a.date)
            ORDER BY YEAR(a.date) ASC, MONTH(a.date) ASC
        ";
            $stmt = $conn->prepare($queryMonthly);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $barangaySlug);
        } else {
            $queryMonthly = "
            SELECT YEAR(date) AS year, MONTHNAME(date) AS month, COUNT(*) AS count
            FROM `" . self::$table . "`
            GROUP BY YEAR(date), MONTH(date)
            ORDER BY YEAR(date) ASC, MONTH(date) ASC
        ";
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

        // Annual summary
        if ($barangaySlug !== null) {
            $queryAnnual = "
            SELECT YEAR(a.date) AS year, COUNT(*) AS total
            FROM `" . self::$table . "` a
            JOIN sk_officials s ON a.sk_official_id = s.id
            JOIN barangays b ON s.barangay_id = b.id
            WHERE b.slug = ?
            GROUP BY YEAR(a.date)
            ORDER BY year ASC
        ";
            $stmt = $conn->prepare($queryAnnual);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("s", $barangaySlug);
        } else {
            $queryAnnual = "
            SELECT YEAR(date) AS year, COUNT(*) AS total
            FROM `" . self::$table . "`
            GROUP BY YEAR(date)
            ORDER BY year ASC
        ";
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
     * Gets the SK Official that this Achievement belongs to.
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
     * Insert achievement
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`sk_official_id`, `title`, `subtitle`, `info`, `img`, `date`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $this->sk_official_id, $this->title, $this->subtitle, $this->info, $this->img, $this->date);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update achievement
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `sk_official_id` = ?, `title` = ?, `subtitle` = ?, `info` = ?, `img` = ?, `date` = ? WHERE `id` = ?");
        $stmt->bind_param("isssssi", $this->sk_official_id, $this->title, $this->subtitle, $this->info, $this->img, $this->date, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Delete achievement
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
