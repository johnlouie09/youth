<?php

require_once __DIR__ . '/Model.php';

class AchievementDate extends Model
{
    /** static data */
    public static $table = 'achievement_date';
    public static $table_columns = [];
    protected static $basic_columns = ['id', 'achievement_id', 'date', 'created_at', 'updated_at'];

    /** properties */
    protected $achievement_id = 0;
    protected $date;
    protected $created_at;
    protected $updated_at;

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

                // ensure ID is stored
                $this->setId((int)$row['id']);
            }
        }
    }

    // -------------------
    // Getters
    // -------------------
    public function getAchievementId(): int { return $this->achievement_id; }
    public function getDate(): ?string { return $this->date; }
    public function getCreatedAt(): ?string { return $this->created_at; }
    public function getUpdatedAt(): ?string { return $this->updated_at; }

    // -------------------
    // Setters
    // -------------------
    public function setAchievementId(int $achievement_id): void { $this->achievement_id = $achievement_id; }
    public function setDate(?string $date): void { $this->date = $date; }

    /**
     * Insert record
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "` (`achievement_id`, `date`) 
            VALUES (?, ?)
        ");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->getConnection()->error);
        }

        $stmt->bind_param(
            "is",
            $this->achievement_id,
            $this->date
        );

        if (!$stmt->execute()) {
            error_log("AchievementDate insert failed: " . $stmt->error);
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
            SET `achievement_id` = ?, `date` = ?
            WHERE `id` = ?
        ");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->getConnection()->error);
        }

        $stmt->bind_param(
            "isi",
            $this->achievement_id,
            $this->date,
            $this->id
        );

        if (!$stmt->execute()) {
            error_log("AchievementDate update failed: " . $stmt->error);
            return false;
        }

        return $stmt->affected_rows > -1;
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
     * Fetch all records for an achievement
     */
    public static function getByAchievement(int $achievement_id, bool $assoc = false): array
    {
        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "` WHERE `achievement_id` = ?");
        $stmt->bind_param("i", $achievement_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $obj = new AchievementDate();
            $obj->hydrate($row);
            $items[] = $assoc ? $obj->getAssoc() : $obj;
        }
        return $items;
    }

    /**
     * Delete all records for an achievement
     */
    public static function deleteByAchievement(int $achievementId): bool
    {
        $conn = self::getConnectionStatic();
        $stmt = $conn->prepare("DELETE FROM `" . self::$table . "` WHERE `achievement_id` = ?");
        $stmt->bind_param("i", $achievementId);
        return $stmt->execute();
    }

    /**
     * Get IDs by achievement
     */
    public static function getIdsByAchievement(int $achievementId): array
    {
        $db = (new self())->getConnection();
        $stmt = $db->prepare("SELECT id FROM `" . self::$table . "` WHERE `achievement_id` = ?");
        $stmt->bind_param("i", $achievementId);
        $stmt->execute();
        $result = $stmt->get_result();

        $ids = [];
        while ($row = $result->fetch_assoc()) {
            $ids[] = $row['id'];
        }
        return $ids;
    }

    /**
     * Convert to associative array
     */
    public function getAssoc(bool $basic = false): array
    {
        return parent::getAssoc($basic);
    }





}
