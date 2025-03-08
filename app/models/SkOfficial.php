<?php

require_once __DIR__ . '/Model.php';

class SkOfficial extends Model
{
    /** static data */
    public static $table = 'sk_officials';
    public static $table_columns = [];
    protected static $basic_columns = ['id', 'full_name'];

    /** properties */
    protected $barangay_id    = 0;
    protected $slug           = '';
    protected $username       = '';
    protected $password       = '';
    protected $full_name      = '';
    protected $position       = '';
    protected $contact_number = '';
    protected $email          = '';
    protected $birthday       = '';
    protected $motto          = '';
    protected $img            = '';
    protected $term_start     = '';
    protected $term_end       = '';


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
     * Gets SkOfficial barangay_id.
     * @return int
     */
    public function getBarangayId()
    {
        return $this->barangay_id;
    }


    /**
     * Gets SkOfficial slug.
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Gets SkOfficial username.
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Gets SkOfficial password.
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Gets SkOfficial full_name.
     * @return string
     */
    public function getFullName()
    {
        return $this->full_name;
    }


    /**
     * Gets SkOfficial position.
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }


    /**
     * Gets SkOfficial contact_number.
     * @return string
     */
    public function getContactNumber()
    {
        return $this->contact_number;
    }

    /**
     * Gets SkOfficial email.
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Gets SkOfficial birthday.
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }


    /**
     * Gets SkOfficial motto.
     * @return string
     */
    public function getMotto()
    {
        return $this->motto;
    }


    /**
     * Gets SkOfficial img.
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }


    /**
     * Gets SkOfficial term_start.
     * @return string
     */
    public function getTermStart()
    {
        return $this->term_start;
    }

    /**
     * Gets SkOfficial term_end.
     * @return string
     */
    public function getTermEnd()
    {
        return $this->term_end;
    }


    /**
     * Sets SkOfficial barangay_id.
     * @param $barangay_id
     * @return void
     */
    public function setBarangayId($barangay_id)
    {
        $this->barangay_id = $barangay_id;
    }


    /**
     * Sets SkOfficial slug.
     * @param $slug
     * @return void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }


    /**
     * Sets SkOfficial username.
     * @param $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


    /**
     * Sets SkOfficial password.
     * @param $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * Sets SkOfficial full_name.
     * @param $full_name
     * @return void
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }


    /**
     * Sets SkOfficial position.
     * @param $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }


    /**
     * Sets SkOfficial contact_number.
     * @param $contact_number
     * @return void
     */
    public function setContactNumber($contact_number)
    {
        $this->contact_number = $contact_number;
    }


    /**
     * Sets SkOfficial email.
     * @param $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * Sets SkOfficial birthday.
     * @param $birthday
     * @return void
     */
    public function setBirhtday($birthday)
    {
        $this->birthday = $birthday;
    }


    /**
     * Sets SkOfficial motto.
     * @param $motto
     * @return void
     */
    public function setMotto($motto)
    {
        $this->motto = $motto;
    }


    /**
     * Sets SkOfficial img.
     * @param $img
     * @return void
     */
    public function setImg($img)
    {
        $this->img = $img;
    }


    /**
     * Sets SkOfficial term_start.
     * @param $term_start
     * @return void
     */
    public function setTermStart($term_start)
    {
        $this->term_start = $term_start;
    }


    /**
     * Sets SkOfficial term_end.
     * @param $term_end
     * @return void
     */
    public function setTermEnd($term_end)
    {
        $this->term_end = $term_end;
    }


    /**
     * Get all SkOfficial.
     * @param $assoc
     * @param $assoc_basic
     * @return array
     */
    public static function all($assoc = false, $assoc_basic = false)
    {
        $sk_officials = [];

        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "`");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sk_official = new SkOfficial();
                $sk_official->hydrate($row);

                $sk_officials[] = $assoc ? $sk_official->getAssoc($assoc_basic) : $sk_official;
            }
        }

        return $sk_officials;
    }
}
