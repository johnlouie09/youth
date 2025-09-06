<?php

require_once __DIR__ . '/Model.php';

class AnnouncementImage extends Model
{
    /** static data */
    public static $table = 'announcement_image';
    public static $table_columns = [];
    protected static $basic_columns = ['id', 'announcement_id', 'name', 'created_at', 'updated_at'];

    /** properties */
    protected $announcement_id = 0;
    protected $name = '';
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
    public function getAnnouncementId(): int { return $this->announcement_id; }
    public function getName(): string { return $this->name; }
    public function getCreatedAt(): string { return $this->created_at; }
    public function getUpdatedAt(): string { return $this->updated_at; }

    /** SETTERS */
    public function setAnnouncementId(int $announcement_id): void { $this->announcement_id = $announcement_id; }
    public function setName(string $name): void { $this->name = $name; }

    /**
     * Insert new image
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "` (`announcement_id`, `name`)
            VALUES (?, ?)
        ");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->getConnection()->error);
        }
        $stmt->bind_param("is", $this->announcement_id, $this->name);
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
            SET `announcement_id` = ?, `name` = ?
            WHERE `id` = ?
        ");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->getConnection()->error);
        }
        $stmt->bind_param("isi", $this->announcement_id, $this->name, $this->id);
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
     * Get images for a specific announcement
     *
     * @param int $announcementId
     * @param bool $assoc
     * @return array
     */
    public static function getByAnnouncement(int $announcementId, bool $assoc = false): array
    {
        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "` WHERE `announcement_id` = ?");
        $stmt->bind_param("i", $announcementId);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $img = new AnnouncementImage();
            $img->hydrate($row);
            $images[] = $assoc ? $img->getAssoc() : $img;
        }
        return $images;
    }

    /**
     * Delete all images for a specific announcement
     */
    public static function deleteByAnnouncement(int $announcementId): bool
    {
        $stmt = self::getConnectionStatic()->prepare("DELETE FROM `" . self::$table . "` WHERE `announcement_id` = ?");
        $stmt->bind_param("i", $announcementId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
