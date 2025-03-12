<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }

abstract class Model
{
    /** static data */
    private static ?mysqli $conn = null;
    private static array $skip_columns = ['created_at', 'updated_at'];


    /** properties */
    protected $id = 0;


    /**
     * Initializes the model.
     */
    public function __construct()
    {
        self::setConnection();
    }


    /**
     * Establishes a database connection if not already set.
     * @return void
     */
    private static function setConnection(): void
    {
        if (self::$conn === null) {
            require __DIR__ . '/../config/database.php';

            if (isset($conn)) {
                self::$conn = $conn;
            }
            else {
                die('Missing database configuration.');
            }
        }
    }


    /**
     * Returns the database connection.
     * @return mysqli|null
     */
    protected function getConnection(): ?mysqli
    {
        return self::$conn;
    }


    /**
     * Retrieves the database connection in a static context.
     * @return mysqli|null
     */
    protected static function getConnectionStatic(): ?mysqli
    {
        self::setConnection();

        return self::$conn;
    }


    /**
     * Gets the Model id.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * Sets the Model id.
     * @param int $id
     * @return void
     */
    protected function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * Gets table columns.
     * @return array
     */
    protected static function getTableColumns(): array
    {
        if (empty(static::$table_columns)) {
            $stmt = static::getConnectionStatic()->prepare("SHOW COLUMNS FROM `" . static::$table . "`");
            $stmt->execute();
            $result = $stmt->get_result();
            $columns = [];
            while ($row = $result->fetch_assoc()) {
                $columns[] = $row['Field'];
            }
            static::setTableColumns($columns);
        }

        return static::$table_columns;
    }


    /**
     * Sets table columns if still empty.
     * @param array $columns
     * @return void
     */
    protected static function setTableColumns(array $columns): void
    {
        if (empty(static::$table_columns)) {
            static::$table_columns = array_diff($columns, self::$skip_columns);
        }
    }


    /**
     * Hydrates model using the given database row.
     * @param $row
     * @return void
     */
    protected function hydrate($row)
    {
        foreach ($row as $key => $value) {
            $setter = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }


    /**
     * Gets the object data as an associative array.
     * @param bool $basic
     * @return array
     */
    public function getAssoc(bool $basic = false): array
    {
        $arr = [];
        $table_columns = $basic ? static::$basic_columns : $this::getTableColumns();
        foreach ($table_columns as $table_column) {
            $getter = 'get' . str_replace('_', '', ucwords($table_column, '_'));
            if (method_exists($this, $getter)) {
                $arr[$table_column] = $this->$getter();
            }
        }
        return $arr;
    }


    /**
     * Retrieves an object by its id.
     * @param int $id
     * @return static|null
     * @throws Exception
     */
    public static function find(int $id): ?static
    {
        $object = new static($id);

        return ($object->getId() > 0) ? $object : null;
    }


    /**
     * Retrieves an object by a given unique column.
     * @param string $column
     * @param mixed $value
     * @param int[] $except_ids
     * @return static|null
     */
    public static function findBy(string $column, mixed $value, array $except_ids = []): null|static
    {
        $object = null;

        if (in_array($column, static::getTableColumns())) {
            $query  = "SELECT * FROM `" . static::$table. "` ";
            $query .= "WHERE `" . $column . "` = ? ";
            if (sizeof($except_ids) > 0) {
                $query .= "AND `id` NOT IN(" . implode(', ', $except_ids) . ") ";
            }
            $query .= "LIMIT 1";
            $stmt = static::getConnectionStatic()->prepare($query);
            $stmt->bind_param('s', $value);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $object = new static();
                $object->hydrate($row);
            }
        }

        return $object;
    }
}