<?php

require_once __DIR__ . '/Model.php';

class AchievementImage extends Model
{
    /** static data */
    public static $table = 'achievement_image';
    public static $table_columns = [];
    protected static $basic_columns = ['id', 'achievement_id', 'img', 'created_at', 'updated_at'];

    /** properties */
    protected $achievement_id = 0;
    protected $img = '';
    protected $created_at = '';
    protected $updated_at = '';

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
            }
        }
    }

    /** GETTERS */
    public function getAchievementId(): int { return $this->achievement_id; }
    public function getImg(): string { return $this->img; }
    public function getCreatedAt(): string { return $this->created_at; }
    public function getUpdatedAt(): string { return $this->updated_at; }

    /** SETTERS */
    public function setAchievementId(int $achievement_id): void { $this->achievement_id = $achievement_id; }
    public function setImg(string $img): void { $this->img = $img; }

    /**
     * Insert new image
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "` (`achievement_id`, `img`)
            VALUES (?, ?)
        ");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->getConnection()->error);
        }
        $stmt->bind_param("is", $this->achievement_id, $this->img);
        if ($stmt->execute()) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }

    /**
     * Update image record
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("
            UPDATE `" . self::$table . "`
            SET `achievement_id` = ?, `img` = ?
            WHERE `id` = ?
        ");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->getConnection()->error);
        }
        $stmt->bind_param("isi", $this->achievement_id, $this->img, $this->id);
        return $stmt->execute();
    }

    /**
     * Delete image record
     */
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Get images for a specific achievement
     *
     * @param int $achievementId
     * @param bool $assoc
     * @return array
     */
    public static function getByAchievement(int $achievementId, bool $assoc = false): array
    {
        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "` WHERE `achievement_id` = ?");
        $stmt->bind_param("i", $achievementId);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $img = new AchievementImage();
            $img->hydrate($row);
            $images[] = $assoc ? $img->getAssoc() : $img;
        }
        return $images;
    }

    /**
     * Delete all images for a specific achievement
     */
    public static function deleteByAchievement(int $achievementId): bool
    {
        $stmt = self::getConnectionStatic()->prepare("DELETE FROM `" . self::$table . "` WHERE `achievement_id` = ?");
        $stmt->bind_param("i", $achievementId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
