<?php

require_once __DIR__ . '/Model.php';

class Feedback extends Model
{
    /** static data */
    public    static $table         = 'feedbacks';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'subject', 'message', 'is_read'];

    /** properties */
    protected $youth_id = '';
    protected $subject  = '';
    protected $message  = '';
    protected $is_read  = '';


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
     * Gets Youth youth_id
     * @return int
     */
    public function getYouthId()
    {
        return $this->youth_id;
    }


    /**
     * Gets Youth subject
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }


    /**
     * Gets Youth message
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Gets Youth is_read
     * @return int
     */
    public function getIsRead()
    {
        return $this->is_read;
    }


    /**
     * Sets Youth youth_id
     * @param $youth_id
     * @return void
     */
    public function setYouthId($youth_id)
    {
        $this->youth_id = $youth_id;
    }


    /**
     * Sets Youth subject
     * @param $subject
     * @return void
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }


    /**
     * Sets Youth message
     * @param $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


    /**
     * Sets Youth is_read
     * @param $is_read
     * @return void
     */
    public function setIsRead($is_read)
    {
        $this->is_read = $is_read;
    }


    /**
     * Retrieves all Youth records, optionally filtering by Youth.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param Youth|null $youth
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?Youth $youth = null): array
    {
        $query = "SELECT * FROM `" . self::$table . "`";
        $params = [];
        $types = '';

        if ($youth !== null) {
            $query .= " WHERE `youth_id` = ?";
            $params[] = $youth->getId();
            $types .= "i";
        }

        $stmt = self::getConnectionStatic()->prepare($query);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $feedbacks = [];

        while ($row = $result->fetch_assoc()) {
            $feedback = new Feedback();
            $feedback->hydrate($row);
            $feedbacks[] = $assoc ? $feedback->getAssoc($assoc_basic) : $feedback;
        }

        return $feedbacks;
    }


    /**
     * Gets the Youth that this Feedback belongs to.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return Youth|array|null
     * @throws Exception
     */
    public function getYouth(bool $assoc = false, bool $assoc_basic = false): Youth|array|null
    {
        require_once __DIR__ . '/Youth.php';
        $youth = Youth::find($this->youth_id);
        return ($assoc && $youth) ? $youth->getAssoc($assoc_basic) : $youth;
    }


    /**
     * Insert youth
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`youth_id`, `subject`, `message`, `is_read`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issss", $this->youth_id, $this->subject, $this->message, $this->is_read);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update youth
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `youth_id` = ?, `subject` = ?, `message` = ?, `is_read` = ? WHERE `id` = ?");
        $stmt->bind_param("issssi", $this->youth_id, $this->subject, $this->message, $this->is_read, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Delete youth
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

