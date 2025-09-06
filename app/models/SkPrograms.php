<?php

require_once __DIR__ . '/Model.php';

class SkPrograms extends Model
{
    protected static $table = 'sk_programs';
    public    static $table_columns = [];
    protected static $basic_columns = [
        'id',
        'sk_platform_id',
        'title',
        'subtitle',
        'detail',
        'thumbnail',
        'status',
        'created_at',
        'updated_at'
    ];

    /** properties */
    protected $sk_platform_id = 0;
    protected $title          = '';
    protected $subtitle       = '';
    protected $detail         = '';
    protected $thumbnail      = '';
    protected $status         = 'Pending';
    protected $created_at     = '';
    protected $updated_at     = '';

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

    // -------------------- GETTERS --------------------
    public function getSkPlatformId() { return $this->sk_platform_id; }
    public function getTitle()        { return $this->title; }
    public function getSubtitle()     { return $this->subtitle; }
    public function getDetail()       { return $this->detail; }
    public function getThumbnail()    { return $this->thumbnail; }
    public function getStatus()       { return $this->status; }
    public function getCreatedAt()    { return $this->created_at; }
    public function getUpdatedAt()    { return $this->updated_at; }

    // -------------------- SETTERS --------------------
    public function setSkPlatformId($sk_platform_id) { $this->sk_platform_id = $sk_platform_id; }
    public function setTitle($title)                 { $this->title = $title; }
    public function setSubtitle($subtitle)           { $this->subtitle = $subtitle; }
    public function setDetail($detail)               { $this->detail = $detail; }
    public function setThumbnail($thumbnail)         { $this->thumbnail = $thumbnail; }
    public function setStatus($status)               { $this->status = $status; }

    // -------------------- CRUD METHODS --------------------

    /**
     * Insert program
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "`
            (`sk_platform_id`, `title`, `subtitle`, `detail`, `thumbnail`, `status`)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("isssss",
            $this->sk_platform_id,
            $this->title,
            $this->subtitle,
            $this->detail,
            $this->thumbnail,
            $this->status
        );
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }

    /**
     * Update program
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("
            UPDATE `" . self::$table . "`
            SET `sk_platform_id` = ?, `title` = ?, `subtitle` = ?, `detail` = ?, `thumbnail` = ?, `status` = ?
            WHERE `id` = ?
        ");
        $stmt->bind_param("isssssi",
            $this->sk_platform_id,
            $this->title,
            $this->subtitle,
            $this->detail,
            $this->thumbnail,
            $this->status,
            $this->id
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Delete program
     */
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Fetch all programs, optionally by SK Official
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?SkOfficial $skOfficial = null): array
    {
        $query = "
            SELECT sp.* 
            FROM `" . self::$table . "` sp
        ";
        $params = [];
        $types  = '';

        if ($skOfficial !== null) {
            $query .= "
                INNER JOIN sk_platforms p ON sp.sk_platform_id = p.id
                INNER JOIN sk_advocacies a ON p.sk_advocacy_id = a.id
                WHERE a.sk_official_id = ?
            ";
            $params[] = $skOfficial->getId();
            $types .= "i";
        }

        $stmt = self::getConnectionStatic()->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        $records = [];
        while ($row = $result->fetch_assoc()) {
            $program = new SkPrograms();
            $program->hydrate($row);
            $records[] = $assoc ? $program->getAssoc($assoc_basic) : $program;
        }

        return $records;
    }



    // -------------------- RELATIONSHIPS --------------------

    /**
     * Get the SK Platform linked to this program
     */
    public function getSkPlatform(bool $assoc = false, bool $assoc_basic = false): array|SkPlatforms|null
    {
        require_once __DIR__ . '/SkPlatforms.php';
        $platform = SkPlatforms::find($this->sk_platform_id);
        return ($assoc && $platform) ? $platform->getAssoc($assoc_basic) : $platform;
    }
}
