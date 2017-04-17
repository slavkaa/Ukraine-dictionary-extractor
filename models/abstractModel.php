<?php
class AbstractModel {

    /**
     * @var PDO
     */
    protected $connection;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var boolean
     */
    protected $isNew;

    /**
     * @var mixed[]
     */
    protected $props = [];

    /**
     * Word constructor.
     * @param PDO $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed[]
     */
    public function getProperties()
    {
        return $this->props;
    }

    /**
     * @param mixed $key
     * @return string
     */
    public function getProperty($key)
    {
        return array_get($this->props, $key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function setProperty($key, $value)
    {
        $this->props[$key] = $value;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return PDOStatement
     */
    public function getAll($limit = 1000000, $offset = 0)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` LIMIT :offset, :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stm->execute();

        return $stm;
    }

    /**
     *
     */
    public function getById($id)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     *
     */
    public function getId()
    {
        return $this->getProperty('id');
    }

    /**
     *
     */
    public function isNew()
    {
        return NULL !== $this->getProperty('id');
    }


    /**
     * @param string $columnName
     * @param string $columnType, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_BOOL, PDO::PARAM_LOB
     * @param mixed $value
     */
    public function updateProperty($columnName, $columnType, $value)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET ' . $columnName . ' = :' . $columnName . ' WHERE id = :id;';
//            var_dump($sql);
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':' . $columnName, $value, $columnType);
            $stm->execute();

//            var_dump($this->connection->errorInfo());

//            echo 'U['. $columnName .':' . $id . '] ';
        } else {
            echo '!!!['. $columnName .'] ';
        }
    }
}