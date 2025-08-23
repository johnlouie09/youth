<?php

require_once __DIR__ . '/Model.php';

class Announcement extends Model
{
    /** static data */
    public    static $table         = 'announcements';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'title', 'date', 'is_featured'];

    /** properties */
    protected $barangay_id = 0;
    protected $title       = '';
    // Announcement.php (class props)
    protected ?int $thumbnail_id = null;
    protected $description = '';
    protected $is_featured = 0;
    protected $what = '';
    protected $who = '';
    protected $why = '';
    protected $where = '';

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
     * Gets Announcement title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Gets Announcement thumbnail_id
     * @return int
     */
    public function getThumbnailId()
    {
        return $this->thumbnail_id;
    }


    /** Gets Announcement description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /** Gets Announcement what
     * @return string
     */
    public function getWhat()
    {
        return $this->what;
    }

    /** Gets Announcement who
     * @return string
     */
    public function getWho()
    {
        return $this->who;
    }

    /** Gets Announcement why
     * @return string
     */
    public function getWhy()
    {
        return $this->why;
    }

    /** Gets Announcement where
     * @return string
     */
    public function getWhere()
    {
        return $this->where;
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
     * Sets Announcement title
     * @param $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Sets Announcement thumbnail_id
     * @param $thumbnail_id
     * @return void
     */
    public function setThumbnailId(?int $thumbnailId): void
    {
        $this->thumbnail_id = $thumbnailId;
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
     * Sets Announcement What Field
     * @param $what
     * @return void
     */
    public function setWhat($what)
    {
        $this->what = $what;
    }

    /**
     * Sets Announcement Why Field
     * @param $why
     * @return void
     */
    public function setWhy($why)
    {
        $this->why = $why;
    }

    /**
     * Sets Announcement Who Field
     * @param $who
     * @return void
     */
    public function setWho($who)
    {
        $this->who = $who;
    }

    /**
     * Sets Announcement Where Field
     * @param $where
     * @return void
     */
    public function setWhere($where)
    {
        $this->where = $where;
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
     * Retrieves all Announcement records, optionally filtering by Barangay.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param Barangay|null $barangay
     * @return array
     * @throws Exception
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

            if ($assoc) {
                $data = $announcement->getAssoc($assoc_basic);

                // ✅ Fetch datetimes
                require_once __DIR__ . '/AnnouncementDatetime.php';
                $datetimes = AnnouncementDatetime::getByAnnouncement($row['id'], true);
                $data['datetimes'] = array_map(function ($dt) {
                    return [
                        'id'    => $dt['id'],
                        'announcementId' => $dt['announcement_id'],
                        'date'  => $dt['date'],
                        'start' => $dt['start_time'],
                        'end'   => $dt['end_time']
                    ];
                }, $datetimes);

                // ✅ Fetch images
                require_once __DIR__ . '/AnnouncementImage.php';
                $images = AnnouncementImage::getByAnnouncement($row['id'], true);
                $data['images'] = array_map(function ($img) {
                    return [
                        'id'    => $img['id'],
                        'announcementId' => $img['announcement_id'],
                        'name'  => $img['name']
                    ];
                }, $images);

                // ✅ Use thumbnail_id if available
                if (!empty($row['thumbnail_id'])) {
                    $thumbnail = array_filter($data['images'], function ($img) use ($row) {
                        return $img['id'] == $row['thumbnail_id'];
                    });
                    $thumbnail = reset($thumbnail);
                    $data['img'] = $thumbnail ? $thumbnail['name'] : (!empty($data['images']) ? $data['images'][0]['name'] : '');
                } else {
                    // fallback to first image
                    $data['img'] = !empty($data['images']) ? $data['images'][0]['name'] : '';
                }

                $announcements[] = $data;
            } else {
                $announcements[] = $announcement;
            }
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
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `announcements` 
            (`barangay_id`, `title`, `description`, `is_featured`, `what`, `who`, `where`, `why`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->getConnection()->error);
        }

        $stmt->bind_param(
            "ississss", 
            $this->barangay_id,
            $this->title,
            $this->description,
            $this->is_featured,
            $this->what,
            $this->who,
            $this->where,
            $this->why
        );

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
        $stmt = $this->getConnection()->prepare("
            UPDATE `" . self::$table . "` 
            SET 
                `barangay_id` = ?, 
                `title` = ?, 
                `description` = ?, 
                `is_featured` = ?, 
                `what` = ?, 
                `who` = ?, 
                `where` = ?, 
                `why` = ?, 
                `thumbnail_id` = ?
            WHERE `id` = ?
        ");

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->getConnection()->error);
        }

        $stmt->bind_param(
            "ississssii",
            $this->barangay_id,
            $this->title,
            $this->description,
            $this->is_featured,
            $this->what,
            $this->who,
            $this->where,
            $this->why,
            $this->thumbnail_id,
            $this->id
        );

        if (!$stmt->execute()) {
            error_log("SQL Execute Error: " . $stmt->error);
            throw new Exception("Failed to execute update: " . $stmt->error);
        }

        error_log("Update executed for ID: {$this->id}, affected_rows: " . $stmt->affected_rows);

        return $stmt->affected_rows >= 0;
    }


    /**
     * Update announcement with datetimes
     *
     * @param array $datetimes Optional array of datetime data
     * @return bool
     * @throws Exception
     */
    public function updateWithDatetimes(array $datetimes = []): bool
    {
        error_log("updateWithDatetimes called for ID: " . $this->getId());
        
        // First update the main announcement
        $updateResult = $this->update();
        error_log("Main update result: " . ($updateResult ? 'true' : 'false'));
        
        if (!$updateResult) {
            error_log("Main announcement update failed");
            return false;
        }

        // Then handle datetimes if provided
        if (!empty($datetimes)) {
            error_log("Processing " . count($datetimes) . " datetimes");
            try {
                $this->updateDatetimes($datetimes);
                error_log("Datetimes updated successfully");
            } catch (Exception $e) {
                error_log("Datetime update failed: " . $e->getMessage());
                // Don't return false here - main update succeeded
                // throw $e; // Uncomment if you want to fail the entire operation
            }
        }

        return true;
    }

    /**
     * Update announcement datetimes
     *
     * @param array $datetimes
     * @return void
     * @throws Exception
     */
    public function updateDatetimes(array $datetimes): void
    {
        require_once __DIR__ . '/AnnouncementDatetime.php';
        
        // Get existing datetimes
        $existingDatetimes = AnnouncementDatetime::getByAnnouncement($this->getId());
        $existingMap = [];
        foreach ($existingDatetimes as $dt) {
            $existingMap[$dt->getId()] = $dt;
        }

        $usedIds = [];

        foreach ($datetimes as $dt) {
            // Validate required fields
            if (empty($dt['date'])) {
                error_log("Skipping datetime with empty date for announcement {$this->getId()}");
                continue;
            }

            // Normalize times to HH:mm:ss format
            $start = $this->normalizeTime($dt['start'] ?? '');
            $end = $this->normalizeTime($dt['end'] ?? '');

            if (!empty($dt['id']) && isset($existingMap[$dt['id']])) {
                // Update existing datetime
                $adt = new AnnouncementDatetime($dt['id']);
                $adt->setDate($dt['date']);
                $adt->setStartTime($start);
                $adt->setEndTime($end);
                
                if ($adt->update()) {
                    $usedIds[] = $dt['id'];
                    error_log("Updated datetime ID {$dt['id']} for announcement {$this->getId()}");
                } else {
                    error_log("Failed to update datetime ID {$dt['id']} for announcement {$this->getId()}");
                }
            } else {
                // Insert new datetime
                $adt = new AnnouncementDatetime();
                $adt->setAnnouncementId($this->getId());
                $adt->setDate($dt['date']);
                $adt->setStartTime($start);
                $adt->setEndTime($end);
                
                if ($adt->insert()) {
                    error_log("Inserted new datetime for announcement {$this->getId()} ({$dt['date']} $start-$end)");
                } else {
                    error_log("Failed to insert new datetime for announcement {$this->getId()}");
                }
            }
        }

        // Delete unused existing datetimes
        foreach ($existingMap as $id => $dt) {
            if (!in_array($id, $usedIds)) {
                $delDt = new AnnouncementDatetime($id);
                if ($delDt->delete()) {
                    error_log("Deleted datetime ID $id for announcement {$this->getId()}");
                } else {
                    error_log("Failed to delete datetime ID $id for announcement {$this->getId()}");
                }
            }
        }
    }

    /**
     * Normalize time format to HH:mm:ss
     *
     * @param string $time
     * @return string
     */
    private function normalizeTime(string $time): string
    {
        if (empty($time)) {
            return '';
        }

        // If already in HH:mm:ss format, return as is
        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
            return $time;
        }

        // If in HH:mm format, add :00
        if (preg_match('/^\d{2}:\d{2}$/', $time)) {
            return $time;
        }

        // If in H:mm format, pad hour
        if (preg_match('/^\d{1}:\d{2}$/', $time)) {
            return '0' . $time;
        }

        // If in H:mm:ss format, pad hour
        if (preg_match('/^\d{1}:\d{2}:\d{2}$/', $time)) {
            return '0' . $time;
        }

        return $time;
    }

    /**
     * Delete announcement
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        // Delete associated datetimes first
        require_once __DIR__ . '/AnnouncementDatetime.php';
        AnnouncementDatetime::deleteByAnnouncement($this->getId());
        
        // Delete the announcement
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function updateThumbnail(): bool
    {
        $stmt = $this->getConnection()->prepare("
            UPDATE `announcements` 
            SET `thumbnail_id` = ? 
            WHERE `id` = ?
        ");

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->getConnection()->error);
        }

        $stmt->bind_param("ii", $this->thumbnail_id, $this->id);

        return $stmt->execute();
    }

}