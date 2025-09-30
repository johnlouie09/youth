<?php
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Barangay.php';

class AuthorizedAccount extends Model {

    public static $table = 'authorized_accounts';
    public    static $table_columns = [];
    protected static $basic_columns = [
        'id',
        'barangay_id',
        'provider',
        'email',
        'name',
        'picture',
        'created_at',
        'updated_at'
    ];

    // Properties
    protected $barangay_id;
    protected $provider;
    protected $provider_user_id;
    protected $email;
    protected $name;
    protected $picture;
    protected $access_token;
    protected $refresh_token;
    protected $created_at;
    protected $updated_at;

    /**
     * Constructor
     * @param int $id
     */
    public function __construct($id = 0) {
        parent::__construct();

        if ($id > 0) {
            $stmt = $this->getConnection()->prepare("SELECT * FROM `" . self::$table . "` WHERE `id` = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->hydrate($row); // handled by parent
            }
        }
    }


    // -------------------- GETTERS --------------------
    public function getBarangayId() { return $this->barangay_id; }
    public function getProvider() { return $this->provider; }
    public function getProviderUserId() { return $this->provider_user_id; }
    public function getEmail() { return $this->email; }
    public function getName() { return $this->name; }
    public function getPicture() { return $this->picture; }
    public function getAccessToken() { return $this->access_token; } // sensitive
    public function getRefreshToken() { return $this->refresh_token; } // sensitive
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }


    // -------------------- SETTERS --------------------
    public function setBarangayId($barangay_id) { $this->barangay_id = $barangay_id; }
    public function setProvider($provider) { $this->provider = $provider; }
    public function setProviderUserId($provider_user_id) { $this->provider_user_id = $provider_user_id; }
    public function setEmail($email) { $this->email = $email; }
    public function setName($name) { $this->name = $name; }
    public function setPicture($picture) { $this->picture = $picture; }
    public function setAccessToken($access_token) { $this->access_token = $access_token; }
    public function setRefreshToken($refresh_token) { $this->refresh_token = $refresh_token; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }


    // -------------------- CRUD METHODS --------------------

    // --- All ---
        /**
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param Barangay|null $barangay
     * @return AuthorizedAccount[]|array[]
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?Barangay $barangay = null):array {
        $query = "SELECT * FROM `" . self::$table . "`";
        $params = [];
        $types = '';

        if($barangay !== null) {
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
        $authorized_accounts = [];

        while($row = $result->fetch_assoc()) {
            $account = new AuthorizedAccount();
            $account->hydrate($row);
            $authorized_accounts[] = $account->getAssoc($assoc_basic);
        }

        return $authorized_accounts;
    }


    // --- Insert ---
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("
            INSERT INTO `" . self::$table . "` 
            (`barangay_id`, `provider`, `provider_user_id`, `email`, `name`, `picture`, `access_token`, `refresh_token`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "isssssss",
            $this->barangay_id,
            $this->provider,
            $this->provider_user_id,
            $this->email,
            $this->name,
            $this->picture,
            $this->access_token,
            $this->refresh_token
        );

        if ($stmt->execute()) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }

    // --- Update ---
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("
            UPDATE `" . self::$table . "` 
            SET `barangay_id` = ?, 
                `provider` = ?, 
                `provider_user_id` = ?, 
                `email` = ?, 
                `name` = ?, 
                `picture` = ?, 
                `access_token` = ?, 
                `refresh_token` = ?
            WHERE `id` = ?
        ");

        $stmt->bind_param(
            "isssssssi",
            $this->barangay_id,
            $this->provider,
            $this->provider_user_id,
            $this->email,
            $this->name,
            $this->picture,
            $this->access_token,
            $this->refresh_token,
            $this->id
        );

        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // --- Delete ---
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("
            DELETE FROM `" . self::$table . "` WHERE `id` = ?
        ");

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // -------------------- UTILITY METHODS --------------------
    public function getBarangay(): Barangay {
        return Barangay::findBy('id', self::getBarangayId());
    }
}
