<?php

require_once __DIR__ . '/Model.php';

class SkOfficial extends Model
{
    /** static data */
    public    static $table                = 'sk_officials';
    public    static $table_columns        = [];
    protected static $basic_columns        = ['id', 'full_name', 'username', 'email'];
    private   static $session_username_key = 'kh0vlaf86ytb7hg9';
    private   static $session_password_key = 'f06vtd9gx1r41tsg';
    private   static $logged_in            = null;
    private   static $logged_out           = false;

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
    public function setBirthday($birthday)
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


    /**
     * Authenticates using the given identifier and password.
     * @param string $identifier
     * @param string $password
     * @param bool $is_password_hashed
     * @return SkOfficial|null
     */
    private static function authenticate(string $identifier, string $password, bool $is_password_hashed = false): ?SkOfficial
    {
        $authenticated = null;

        // find the sk_official using the given identifier
        $column = (filter_var($identifier, FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';
        $sk_official = SkOfficial::findBy($column, $identifier);

        // if sk_official is found, verify the given password
        if ($sk_official) {
            if ((!$is_password_hashed && $sk_official->getPassword() === $password) || ($is_password_hashed && password_verify(base64_encode($sk_official->getPassword()), $password))) {
                $authenticated = $sk_official;
            }
        }

        return $authenticated;
    }
    
    
    /**
     * Attempts to log in using the given identifier and password.
     * @param string $identifier
     * @param string $password
     * @param bool $remember
     * @return SkOfficial
     * @throws Exception
     */
    public static function login(string $identifier, string $password, bool $remember = false): SkOfficial
    {
        if (self::getLoggedIn() !== null) {
            self::logout();
        }
        
        // authenticate
        $sk_official = self::authenticate($identifier, $password);
        if ($sk_official === null) {
            throw new Exception('Invalid credentials');
        }
        
        // encode credentials
        $encoded_username = base64_encode($sk_official->getUsername());
        $encoded_password = base64_encode(password_hash(base64_encode($sk_official->getPassword()), PASSWORD_DEFAULT));

        // store encoded credentials in session
        $_SESSION[self::$session_username_key] = $encoded_username;
        $_SESSION[self::$session_password_key] = $encoded_password;

        // if remembered, store credentials in cookies as well
        if ($remember) {
            $cookie_expiration = time() + (86400 * 15); // n days
            $cookie_path       = '/';
            setcookie(self::$session_username_key, $encoded_username, $cookie_expiration, $cookie_path);
            setcookie(self::$session_password_key, $encoded_password, $cookie_expiration, $cookie_path);
        }

        self::$logged_in  = $sk_official;
        self::$logged_out = false;

        return $sk_official;
    }


    /**
     * Gets logged in SkOfficial.
     * @return SkOfficial|null
     */
    public static function getLoggedIn(): ?SkOfficial
    {
        if (!self::$logged_out && (self::$logged_in === null)) {
            // get remembered credentials
            if (!isset($_SESSION[self::$session_username_key]) || !isset($_SESSION[self::$session_password_key])) {
                if (isset($_COOKIE[self::$session_username_key]) && isset($_COOKIE[self::$session_password_key])) {
                    $_SESSION[self::$session_username_key] = $_COOKIE[self::$session_username_key];
                    $_SESSION[self::$session_password_key] = $_COOKIE[self::$session_password_key];
                }
            }

            // attempt to get logged in sk_official
            if (isset($_SESSION[self::$session_username_key]) && isset($_SESSION[self::$session_password_key])) {
                // decode credentials
                $decoded_username = base64_decode($_SESSION[self::$session_username_key]);
                $decoded_password = base64_decode($_SESSION[self::$session_password_key]);

                self::$logged_in  = self::authenticate($decoded_username, $decoded_password, true);
            }
        }

        return self::$logged_in;
    }


    /**
     * Clears logged in.
     * @return void
     */
    public static function logout(): void
    {
        // delete session
        if (isset($_SESSION[self::$session_username_key])) {
            unset($_SESSION[self::$session_username_key]);
        }
        if (isset($_SESSION[self::$session_password_key])) {
            unset($_SESSION[self::$session_password_key]);
        }

        // delete cookies as well
        $cookie_expiration = time() - 3600;
        $cookie_path       = '/';
        setcookie(self::$session_username_key, '', $cookie_expiration, $cookie_path);
        setcookie(self::$session_password_key, '', $cookie_expiration, $cookie_path);

        // clear cache
        self::$logged_in  = null;
        self::$logged_out = true;
    }


    /**
     * Insert sk_education
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`sk_official_id`, `education_level_id`, `school_name`, `course`, `start_year`, `end_year`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissii", $this->sk_official_id, $this->education_level_id, $this->school_name, $this->course, $this->start_year, $this->end_year);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update sk_education
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `sk_official_id` = ?, `education_level_id` = ?, `school_name` = ?, `course` = ?, `start_year` = ?, `end_year` = ? WHERE `id` = ?");
        $stmt->bind_param("iissiii", $this->sk_official_id, $this->education_level_id, $this->school_name, $this->course, $this->start_year, $this->end_year, $this->id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;
    }


    /**
     * Delete sk_education
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


    /**
     * Retrieves the education background for this SK Official.
     * @return array
     */
    public function getEducationBackground(): array
    {
        $conn = $this->getConnection();
        $sql = "SELECT 
                    so.full_name,
                    el.name AS education_level,
                    se.school_name,
                    se.course,
                    se.start_year,
                    se.end_year
                FROM `" . self::$table . "` so
                JOIN sk_educations se ON so.id = se.sk_official_id
                JOIN education_levels el ON se.education_level_id = el.id
                WHERE so.id = ?
                ORDER BY el.sort_order";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $educationBackground = [];
        while ($row = $result->fetch_assoc()) {
            $educationBackground[] = $row;
        }

        return $educationBackground;
    }
}
