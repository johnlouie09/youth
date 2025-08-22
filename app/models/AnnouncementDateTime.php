<?php

require_once __DIR__ . '/Model.php';

class AnnouncementDatetime extends Model
{
    /** static data */
    public static $table = 'announcement_datetime';
    public static $table_columns = [];
    protected static $basic_columns = ['id', 'announcement_id', 'date', 'start_time', 'end_time'];

    /** properties */
    protected $announcement_id = 0;
    protected $date;
    protected $start_time;
    protected $end_time;

    /**
     * Constructor
     * @param int $id
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
                
                // 🔥 Make sure ID is stored
                $this->setId((int)$row['id']); //
            }
        }
    }

    // -------------------
    // Getters
    // -------------------
    public function getAnnouncementId(): int { return $this->announcement_id; }
    public function getDate(): ?string { return $this->date; }
    public function getStartTime(): ?string { return $this->start_time; }
    public function getEndTime(): ?string { return $this->end_time; }


    // -------------------
    // Setters
    // -------------------
    public function setAnnouncementId(int $announcement_id): void { $this->announcement_id = $announcement_id; }
    public function setDate(?string $date): void { $this->date = $date; }
    public function setStartTime(?string $start_time): void { $this->start_time = $start_time; }
    public function setEndTime(?string $end_time): void { $this->end_time = $end_time; }


    /**
     * Insert record
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "` (`announcement_id`, `date`, `start_time`, `end_time`) 
            VALUES (?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->getConnection()->error);
        }

        $stmt->bind_param(
            "isss",
            $this->announcement_id,
            $this->date,
            $this->start_time,
            $this->end_time
        );

        if (!$stmt->execute()) {
            error_log("Datetime insert failed: " . $stmt->error);
            throw new Exception("Insert failed: " . $stmt->error);
        }

        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }

        return false;
    }

    /**
     * Update record
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("
            UPDATE `" . self::$table . "` 
            SET `announcement_id` = ?, `date` = ?, `start_time` = ?, `end_time` = ?
            WHERE `id` = ?
        ");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->getConnection()->error);
        }

        $stmt->bind_param(
            "isssi",
            $this->announcement_id,
            $this->date,
            $this->start_time,
            $this->end_time,
            $this->id
        );

        if (!$stmt->execute()) {
            error_log("Datetime update failed: " . $stmt->error);
            return false; // ❌ don’t throw, return false so caller can handle gracefully
        }

        return $stmt->affected_rows > -1; // true even if no changes
    }

    /**
     * Delete record
     */
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Fetch all records for an announcement
     */
    public static function getByAnnouncement(int $announcement_id, bool $assoc = false): array
    {
        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "` WHERE `announcement_id` = ?");
        $stmt->bind_param("i", $announcement_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $obj = new AnnouncementDatetime();
            $obj->hydrate($row);
            $items[] = $assoc ? $obj->getAssoc() : $obj;
        }
        return $items;
    }

    /**
     * Convert to associative array
     */
    public function getAssoc(bool $basic = false): array
    {
        return parent::getAssoc($basic);
    }

    public static function deleteByAnnouncement(int $announcementId): bool {
        $conn = self::getConnectionStatic();
        $stmt = $conn->prepare("DELETE FROM `announcement_datetime` WHERE `announcement_id` = ?");
        $stmt->bind_param("i", $announcementId);
        return $stmt->execute();
    }

    public static function getIdsByAnnouncement(int $announcementId): array
    {
        $db = (new self())->getConnection();
        $stmt = $db->prepare("SELECT id FROM `" . self::$table . "` WHERE `announcement_id` = ?");
        $stmt->bind_param("i", $announcementId);
        $stmt->execute();
        $result = $stmt->get_result();

        $ids = [];
        while ($row = $result->fetch_assoc()) {
            $ids[] = $row['id'];
        }
        return $ids;
    }
}


