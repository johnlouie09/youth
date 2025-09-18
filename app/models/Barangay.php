<?php
declare(strict_types=1);
use Firebase\JWT\JWT;
require_once('../vendor/autoload.php');


require_once __DIR__ . '/Model.php';

class Barangay extends Model
{
    /** static data */
    public    static $table         = 'barangays';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'slug', 'name', 'img', 'sk_barangay_logo', 'is_agreed', 'username'];

    /** properties */
    protected $cluster_id               = 0;
    protected $slug                     = '';
    protected $name                     = '';
    protected $img                      = '';
    protected $sk_barangay_logo         = '';
    protected $username                 = '';
    protected $password                 = '';
    protected $is_agreed                = 0;


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

    // -------------------- GETTERS --------------------
    /**
     * Gets Barangay cluster_id.
     * @return int
     */
    public function getClusterId()
    {
        return $this->cluster_id;
    }

    /**
     * Gets Barangay slug.
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Gets Barangay name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets Barangay img.
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Gets Barangay Logo .
     * @return string
     */
    public function getSkBarangayLogo()
    {
        return $this->sk_barangay_logo;
    }

    /**
     * Gets Barangay username.
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Gets Barangay Password.
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets Barangay is_agreed
     * @return int
     */
    public function getIsAgreed()
    {
        return $this->is_agreed;
    }


    // -------------------- SETTERS --------------------
    /**
     * Sets Barangay cluster_id.
     * @param $cluster_id
     * @return void
     */
    public function setClusterId($cluster_id)
    {
        $this->cluster_id = $cluster_id;
    }

    /**
     * Sets Barangay slug.
     * @param $slug
     * @return void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Sets Barangay name.
     * @param $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Sets Barangay img.
     * @param $img
     * @return void
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * Sets Barangay Logo.
     * @param $sk_barangay_logo
     * @return void
     */
    public function setSkBarangayLogo($sk_barangay_logo)
    {
        $this->sk_barangay_logo = $sk_barangay_logo;
    }

    /**
     * Sets Barangay Username.
     * @param $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Sets Barangay Password.
     * @param $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Sets Barangay is_agreed
     * @param $is_agreed
     * @return void
    */
    public function setIsAgreed($is_agreed)
    {
        $this->is_agreed = $is_agreed;
    }


    // -------------------- CRUD OPERATIONS --------------------
    
    // Insert barangay
    /**
    * @return bool
    * @throws Exception 
    */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`cluster_id`, `slug`, `name`, `img`, `is_agreed`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $this->cluster_id, $this->slug, $this->name, $this->img, $this->is_agreed);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }

    /**
     * Update barangay
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `cluster_id` = ?, `slug` = ?, `name` = ?, `img` = ?, `is_agreed` = ? WHERE `id` = ?");
        $stmt->bind_param("isssii", $this->cluster_id, $this->slug, $this->name, $this->img, $this->is_agreed, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Delete barangay
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
    
    /**
     * Retrieves all Barangay records, optionally filtering by Cluster.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param Cluster|null $cluster
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?Cluster $cluster = null): array
    {
        $query = "SELECT * FROM `" . self::$table . "`";
        $params = [];
        $types = '';

        if ($cluster !== null) {
            $query .= " WHERE `cluster_id` = ?";
            $params[] = $cluster->getId();
            $types .= "i";
        }

        $stmt = self::getConnectionStatic()->prepare($query);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $barangays = [];

        while ($row = $result->fetch_assoc()) {
            $barangay = new Barangay();
            $barangay->hydrate($row);
            $barangays[] = $assoc ? $barangay->getAssoc($assoc_basic) : $barangay;
        }

        return $barangays;
    }


    // -------------------- AUTHENTICATION & JWT AUTHORIZATION MANAGEMENT --------------------
    /**
     * Authenticates using the given identifier and password.
     * @param string $identifier
     * @param string $password
     * @param bool $is_password_hashed
     * @return Barangay|null
     */
    private static function authenticate(string $identifier, string $password): ?Barangay
    {
        $barangay = Barangay::findBy('username', $identifier);
        if ($barangay === null) {
            return null;
        }


        $storedPassword = $barangay->getPassword();
        $info = password_get_info($storedPassword);



        // Case 1: password is hashed with password_hash()
        if ($info['algo'] !== 0 && password_verify($password, $storedPassword)) {
            return $barangay;
        }

        // Case 2: password is plaintext (legacy accounts)
        if (empty($info['algo']) && $password === $storedPassword) {
            $barangay->setPassword(password_hash($password, PASSWORD_BCRYPT));
            $barangay->update();
            return $barangay;
        }

        return null;
    }
    
    /**
     * Attempts to log in using the given identifier and password.
     * @param string $identifier
     * @param string $password
     * @return Barangay
     * @throws Exception
     */
    public static function login(string $identifier, string $password): Barangay
    {   
        // Authenticate
        $barangay = self::authenticate($identifier, $password);
        if ($barangay === null) {
            throw new Exception('Invalid credentialswswsre');
        }


        // Create the JWT Token if Authenticated
        $date   = new DateTimeImmutable();
        $expire_at = $date->modify('+4 week')->getTimestamp();
        $request_data = [
            'iss'  => 'localhost.youth',                    // Issuer
            'iat'  => $date->getTimestamp(),                // Issued at: time when the token was generated
            'exp'  => $expire_at,                           // Expire
            'skOfficialId' => $barangay->getId(),
            'position' => $barangay->getName(),                  
        ];

        // Create the Token
        $jwt = JWT::encode($request_data, $GLOBALS['secret_key'], 'HS256');      

        // Create and Set the JWT Cookie
        setcookie(
            "jwt",
            $jwt,
            [
                "path" => "/",

                // Set this to true in production
                "secure" => false,     // only HTTPS


                "httponly" => true,   // JavaScript can’t read it
                "samesite" => "Strict"
            ]
        );


        return $barangay;
    }


    /** -------------------- UTILITY FUNCTIONS -------------------- */ 



    /**
     * Gets the SK Chairperson for this Barangay.
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return SkOfficial|array|null
     */
    public function getSkChairman(bool $assoc = false, bool $assoc_basic = false): SkOfficial|array|null
    {
        require_once __DIR__ . '/SkOfficial.php';
        $skOfficials = $this->getSkOfficials();
        foreach ($skOfficials as $official) {
            if (is_array($official)) {
                if ($official['position'] === SkOfficial::POSITION_SK_CHAIRPERSON) {
                    return $official;
                }
            } else {
                if ($official->getPosition() === SkOfficial::POSITION_SK_CHAIRPERSON) {
                    return $assoc ? $official->getAssoc($assoc_basic) : $official;
                }
            }
        }
        return null;
    }

    /**
     * Gets the SK Members for this Barangay.
     *
     * Returns SK Officials with positions "SK Secretary", "SK Treasurer", and "SK Kagawad".
     * Optionally, if $excludeChairman is false, it will also include the SK Chairperson.
     *
     * @param bool $excludeChairman
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getSkMembers(bool $excludeChairman = true, bool $assoc = false, bool $assoc_basic = false): array
    {
        require_once __DIR__ . '/SkOfficial.php';
        $skOfficials = $this->getSkOfficials($assoc, $assoc_basic);
        $members = [];
        $memberPositions = [
            SkOfficial::POSITION_SK_SECRETARY,
            SkOfficial::POSITION_SK_TREASURER,
            SkOfficial::POSITION_SK_KAGAWAD,
        ];
        if (!$excludeChairman) {
            $memberPositions[] = SkOfficial::POSITION_SK_CHAIRPERSON;
        }
        foreach ($skOfficials as $official) {
            if (is_array($official)) {
                if (in_array($official['position'], $memberPositions)) {
                    $members[] = $official;
                }
            } else {
                if (in_array($official->getPosition(), $memberPositions)) {
                    $members[] = $assoc ? $official->getAssoc($assoc_basic) : $official;
                }
            }
        }
        return $members;
    }



    /**
     * Gets the Cluster that this Barangay belongs to.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return Cluster|array|null
     * @throws Exception
     */
    public function getCluster(bool $assoc = false, bool $assoc_basic = false): Cluster|array|null
    {
        require_once __DIR__ . '/Cluster.php';
        $cluster = Cluster::find($this->cluster_id);
        return ($assoc && $cluster) ? $cluster->getAssoc($assoc_basic) : $cluster;
    }


    /**
     * Gets all SK Officials that belong to this Barangay.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getSkOfficials(bool $assoc = false, bool $assoc_basic = false): array
    {
        require_once __DIR__ . '/SkOfficial.php';
        return SkOfficial::all($assoc, $assoc_basic, $this);
    }


    /**
     * Gets all Events that belong to this Barangay.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getEvents(bool $assoc = false, bool $assoc_basic = false): array
    {
        require_once __DIR__ . '/Event.php';
        return Event::all($assoc, $assoc_basic, $this);
    }


    /**
     * Gets all Projects that belong to this Barangay.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getProjects(bool $assoc = false, bool $assoc_basic = false): array
    {
        require_once __DIR__ . '/Project.php';
        return Project::all($assoc, $assoc_basic, $this);
    }


    /**
     * Gets all Announcements that belong to this Barangay.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getAnnouncements(bool $assoc = false, bool $assoc_basic = false): array
    {
        require_once __DIR__ . '/Announcement.php';
        return Announcement::all($assoc, $assoc_basic, $this);
    }

    /**
     * Gets all achievements for this Barangay across all its SK Officials.
     *
     * This method retrieves every SK Official in this Barangay and then merges all of their achievements.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getAllAchievements(bool $assoc = false, bool $assoc_basic = false): array
    {
        $allAchievements = [];
        // retrieve all SK Officials for this Barangay
        $skOfficials = $this->getSkOfficials();
        require_once __DIR__ . '/Achievement.php';
        foreach ($skOfficials as $official) {
            // ensure we have an object instance
            if (!is_object($official)) {
                require_once __DIR__ . '/SkOfficial.php';
                $official = new SkOfficial($official['id']);
            }
            // retrieve the achievements for this SK Official
            $achievements = $official->getAchievements($assoc, $assoc_basic);
            // merge them into one array
            $allAchievements = array_merge($allAchievements, $achievements);
        }
        return $allAchievements;
    }

}
