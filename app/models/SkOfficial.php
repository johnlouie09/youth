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
     * @return int
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Gets SkOfficial fullname.
     * @return int
     */
    public function getFullname()
    {
        return $this->full_name;
    }

    // TODO: COMPLETE ALL GETTER METHODS FOR ALL PROPERTIES





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
     * Sets SkOfficial full_name.
     * @param $fullname
     * @return void
     */
    public function setFullname($fullname)
    {
        $this->full_name = $fullname;
    }

    // TODO: COMPLETE ALL SETTER METHODS FOR ALL PROPERTIES






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
     * Find an SkOfficial by id.
     * @param $id
     * @return SkOfficial|null
     */
    public static function find($id = 0)
    {
        $sk_official = new SkOfficial($id);

        return ($sk_official->getId() > 0) ? $sk_official : null;
    }
}
