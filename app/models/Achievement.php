<?php

require_once __DIR__ . '/Model.php';

class Achievement extends Model
{
    /** static data */
    public    static $table         = 'achievements';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'title', 'info', 'date'];

    /** properties */
    protected $sk_official_id = 0;
    protected $title          = '';
    protected $subtitle       = '';
    protected $info           = '';
    protected $img            = '';
    protected $date           = '';


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
     * Retrieves all Achievement records, optionally filtering by SK Official.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param SkOfficial|null $skOfficial
     * @return array
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
        $achievements = [];
        while ($row = $result->fetch_assoc()) {
            $achievement = new Achievement();
            $achievement->hydrate($row);
            $achievements[] = $assoc ? $achievement->getAssoc($assoc_basic) : $achievement;
        }
        return $achievements;
    }


    /**
     * Gets the SK Official that this Achievement belongs to.
     *
     * @return SkOfficial|null
     * @throws Exception
     */
    public function getSkOfficial(): ?SkOfficial
    {
        require_once __DIR__ . '/SkOfficial.php';
        return SkOfficial::find($this->sk_official_id);
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
