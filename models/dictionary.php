<?php
require_once('Abstract\AbstractModel.php');

class Dictionary extends AbstractModel {

    /**
     * @var string
     */
    protected $tableName = 'dictionary';

    /**
     * @var mixed[]
     */
    protected $props = [
        'name' => null,
        'base_url' => null,
    ];

    /**
     * @param string $name
     * @param string $baseUrl
     */
    public function firstOrNew($name, $baseUrl)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE name = :name;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':name', $name, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[dictionary] ';
        } else {
            echo 'I[dictionary] ';
            $sql = 'INSERT INTO `' . $this->tableName . '` (`name`, `base_url`) VALUES (:name, :base_url );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':name', $name, PDO::PARAM_STR);
            $stm->bindParam(':base_url', $baseUrl, PDO::PARAM_STR);
            $stm->execute();
            $id = $this->connection->lastInsertId();

//            var_dump($sql);
//            var_dump($stm);
//            var_dump($this->connection->errorInfo());
//            var_dump($id);

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }
}