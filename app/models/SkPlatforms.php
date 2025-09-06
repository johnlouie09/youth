<?php

require_once __DIR__ . '/Model.php';

class SkPlatforms extends Model
{
    protected static $table = 'sk_platforms';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'sk_advocacy_id', 'title', 'detail', 'created_at', 'updated_at'];

    /** properties */
    protected $sk_advocacy_id = 0;
    protected $title          = '';
    protected $detail         = '';
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
    public function getSkAdvocacyId() { return $this->sk_advocacy_id; }
    public function getTitle()        { return $this->title; }
    public function getDetail()       { return $this->detail; }
    public function getCreatedAt()    { return $this->created_at; }
    public function getUpdatedAt()    { return $this->updated_at; }

    // -------------------- SETTERS --------------------
    public function setSkAdvocacyId($sk_advocacy_id) { $this->sk_advocacy_id = $sk_advocacy_id; }
    public function setTitle($title)                 { $this->title = $title; }
    public function setDetail($detail)               { $this->detail = $detail; }

    // -------------------- CRUD METHODS --------------------

    /**
     * Insert sk_platform
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "`
            (`sk_advocacy_id`, `title`, `detail`)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("iss",
            $this->sk_advocacy_id,
            $this->title,
            $this->detail
        );
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }

    /**
     * Update sk_platform
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("
            UPDATE `" . self::$table . "`
            SET `sk_advocacy_id` = ?, `title` = ?, `detail` = ?
            WHERE `id` = ?
        ");
        $stmt->bind_param("issi",
            $this->sk_advocacy_id,
            $this->title,
            $this->detail,
            $this->id
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Delete sk_platform
     */
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Fetch all platforms, optionally by SK Official
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?SkOfficial $skOfficial = null): array
    {
        $query = "SELECT p.* FROM `" . self::$table . "` p";
        $params = [];
        $types = '';

        if ($skOfficial !== null) {
            $query .= " JOIN sk_advocacies a ON p.sk_advocacy_id = a.id WHERE a.sk_official_id = ?";
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
            $platform = new SkPlatforms();
            $platform->hydrate($row);
            $records[] = $assoc ? $platform->getAssoc($assoc_basic) : $platform;
        }
        return $records;
    }

    // -------------------- RELATION METHODS --------------------

    /**
     * Get the advocacy linked to this platform
     */
    public function getSkAdvocacy(bool $assoc = false, bool $assoc_basic = false): array|SkAdvocacies|null
    {
        require_once __DIR__ . '/SkAdvocacies.php';
        $advocacy = SkAdvocacies::find($this->sk_advocacy_id);
        return ($assoc && $advocacy) ? $advocacy->getAssoc($assoc_basic) : $advocacy;
    }
}
