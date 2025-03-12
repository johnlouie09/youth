<?php

require_once __DIR__ . '/Model.php';

class Event extends Model
{
    /** static data */
    public    static $table         = 'events';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'event_name', 'event_date', 'location', 'description'];

    /** properties */
    protected $barangay_id = 0;
    protected $event_name  = '';
    protected $event_date  = '';
    protected $location    = '';
    protected $description = '';


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
     * Gets Event barangay_id.
     * @return int
     */
    public function getBarangayId()
    {
        return $this->barangay_id;
    }


    /**
     * Gets Event event_name.
     * @return string
     */
    public function getEventName()
    {
        return $this->event_name;
    }


    /**
     * Gets Event event_date.
     * @return string
     */
    public function getEventDate()
    {
        return $this->event_date;
    }


    /**
     * Gets Event location.
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }


    /**
     * Gets Event description.
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Sets Event barangay_id.
     * @param $barangay_id
     * @return void
     */
    public function setBarangayId($barangay_id)
    {
        $this->barangay_id = $barangay_id;
    }


    /**
     * Sets Event event_name.
     * @param $event_name
     * @return void
     */
    public function setEventName($event_name)
    {
        $this->event_name = $event_name;
    }


    /**
     * Sets Event event_date.
     * @param $event_date
     * @return void
     */
    public function setEventDate($event_date)
    {
        $this->event_date = $event_date;
    }


    /**
     * Sets Event location.
     * @param $location
     * @return void
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }


    /**
     * Sets Event description.
     * @param $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * Get all Event.
     * @param $assoc
     * @param $assoc_basic
     * @return array
     */
    public static function all($assoc = false, $assoc_basic = false)
    {
        $events = [];

        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "`");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $event = new Event();
                $event->hydrate($row);

                $events[] = $assoc ? $event->getAssoc($assoc_basic) : $event;
            }
        }

        return $events;
    }


    /**
     * Insert event
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`barangay_id`, `event_name`, `event_date`, `location`, `description`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $this->barangay_id, $this->event_name, $this->event_date, $this->location, $this->description);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update event
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `barangay_id` = ?, `event_name` = ?, `event_date` = ?, `location` = ?, `description` = ? WHERE `id` = ?");
        $stmt->bind_param("issssi", $this->barangay_id, $this->event_name, $this->event_date, $this->location, $this->description, $this->id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }


    /**
     * Delete event
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }
}
