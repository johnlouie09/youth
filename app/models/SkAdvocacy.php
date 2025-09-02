<?php

require_once __DIR__ . '/Model.php';

class SkAdvocacy extends Model
{
    protected static $table = 'sk_advocacies';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'sk_official_id', 'title', 'subtitle', 'detail', 'thumbnail', 'created_at', 'updated_at'];

    /** properties */
    protected $sk_official_id = 0;
    protected $title          = '';
    protected $subtitle       = '';
    protected $detail         = '';
    protected $thumbnail      = '';
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
    public function getSkOfficialId() { return $this->sk_official_id; }
    public function getTitle()        { return $this->title; }
    public function getSubtitle()     { return $this->subtitle; }
    public function getDetail()       { return $this->detail; }
    public function getThumbnail()    { return $this->thumbnail; }
    public function getCreatedAt()    { return $this->created_at; }
    public function getUpdatedAt()    { return $this->updated_at; }

    // -------------------- SETTERS --------------------
    public function setSkOfficialId($sk_official_id) { $this->sk_official_id = $sk_official_id; }
    public function setTitle($title)                 { $this->title = $title; }
    public function setSubtitle($subtitle)           { $this->subtitle = $subtitle; }
    public function setDetail($detail)               { $this->detail = $detail; }
    public function setThumbnail($thumbnail)         { $this->thumbnail = $thumbnail; }

    // -------------------- CRUD METHODS --------------------

    /**
     * Insert sk_advocacy
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "`
            (`sk_official_id`, `title`, `subtitle`, `detail`, `thumbnail`)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("issss",
            $this->sk_official_id,
            $this->title,
            $this->subtitle,
            $this->detail,
            $this->thumbnail
        );
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }

    /**
     * Update sk_advocacy
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("
            UPDATE `" . self::$table . "`
            SET `sk_official_id` = ?, `title` = ?, `subtitle` = ?, `detail` = ?, `thumbnail` = ?
            WHERE `id` = ?
        ");
        $stmt->bind_param("issssi",
            $this->sk_official_id,
            $this->title,
            $this->subtitle,
            $this->detail,
            $this->thumbnail,
            $this->id
        );
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Delete sk_advocacy
     */
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Fetch all advocacies, optionally by SK Official
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?SkOfficial $skOfficial = null): array
    {
        $query = "SELECT * FROM `" . self::$table . "`";
        $params = [];
        $types = '';

        if ($skOfficial !== null) {
            $query .= " WHERE `sk_official_id` = ?";
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
            $advocacy = new SkAdvocacy();
            $advocacy->hydrate($row);
            $records[] = $assoc ? $advocacy->getAssoc($assoc_basic) : $advocacy;
        }
        return $records;
    }

    /**
     * Get the SK Official linked to this advocacy
     */
    public function getSkOfficial(bool $assoc = false, bool $assoc_basic = false): array|SkOfficial|null
    {
        require_once __DIR__ . '/SkOfficial.php';
        $skOfficial = SkOfficial::find($this->sk_official_id);
        return ($assoc && $skOfficial) ? $skOfficial->getAssoc($assoc_basic) : $skOfficial;
    }
}
