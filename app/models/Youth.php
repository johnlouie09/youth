<?php

require_once __DIR__ . '/Model.php';

class Youth extends Model
{
    /** static data */
    public    static $table         = 'youths';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'username', 'full_name', 'email'];

    /** properties */
    protected $barangay_id = '';
    protected $username    = '';
    protected $password    = '';
    protected $full_name   = '';
    protected $email       = '';


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
     * Gets Youth barangay_id
     * @return int
     */
    public function getBarangayId()
    {
        return $this->barangay_id;
    }


    /**
     * Gets Youth username
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Gets Youth password
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Gets Youth full_name
     * @return string
     */
    public function getFullName()
    {
        return $this->full_name;
    }


    /**
     * Gets Youth email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Sets Youth barangay_id
     * @param $barangay_id
     * @return void
     */
    public function setBarangayId($barangay_id)
    {
        $this->barangay_id = $barangay_id;
    }


    /**
     * Sets Youth username
     * @param $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


    /**
     * Sets Youth password
     * @param $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * Sets Youth full_name
     * @param $full_name
     * @return void
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }


    /**
     * Sets Youth  email
     * @param $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * Retrieves all Youth records, optionally filtering by Barangay.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param Barangay|null $barangay
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?Barangay $barangay = null): array
    {
        $query = "SELECT * FROM `" . self::$table . "`";
        $params = [];
        $types = '';

        if ($barangay !== null) {
            $query .= " WHERE `barangay_id` = ?";
            $params[] = $barangay->getId();
            $types .= "i";
        }

        $stmt = self::getConnectionStatic()->prepare($query);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $youths = [];

        while ($row = $result->fetch_assoc()) {
            $youth = new Youth();
            $youth->hydrate($row);
            $youths[] = $assoc ? $youth->getAssoc($assoc_basic) : $youth;
        }

        return $youths;
    }


    /**
     * Gets the Barangay that this Youth belongs to.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return Barangay|array|null
     * @throws Exception
     */
    public function getBarangay(bool $assoc = false, bool $assoc_basic = false): Barangay|array|null
    {
        require_once __DIR__ . '/Barangay.php';
        $barangay = Barangay::find($this->barangay_id);
        return ($assoc && $barangay) ? $barangay->getAssoc($assoc_basic) : $barangay;
    }


    /**
     * Gets all Feedbacks that belong to this Youth.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getFeedbacks(bool $assoc = false, bool $assoc_basic = false): array
    {
        require_once __DIR__ . '/Feedback.php';
        return Feedback::all($assoc, $assoc_basic, $this);
    }


    /**
     * Insert youth
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`barangay_id`, `username`, `password`, `full_name`, `email`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $this->barangay_id, $this->username, $this->password, $this->full_name, $this->email);
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
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `barangay_id` = ?, `username` = ?, `password` = ?, `full_name` = ?, `email` = ? WHERE `id` = ?");
        $stmt->bind_param("issssi", $this->barangay_id, $this->username, $this->password, $this->full_name, $this->email, $this->id);
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

