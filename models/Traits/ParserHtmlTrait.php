<?php

trait ParserHtmlTrait
{
    /**
     *
     */
    public function getByDataId($id)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE data_id = :id;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->props = $result;
    }

    /**
     * @param string $dataId
     * @param string $word
     */
    public function firstOrNew($dataId, $word)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE data_id = :data_id limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':data_id', $dataId, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

//        var_dump($dataId, $word);
//        var_dump($sql);
//        var_dump($result);
//        var_dump($this->connection->errorInfo());
//        var_dump($stm->errorInfo());

        if (empty($result) || false === $result) {


            $sql = 'INSERT INTO `' . $this->tableName .
                '` ( `data_id`, `word`, `word_binary`) VALUES (:data_id, :word, :word );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':data_id', $dataId, PDO::PARAM_INT);
            $stm->execute();

            $id = $dataId; // there is no primary key here

//            var_dump($sql);
//            var_dump($id);
//            var_dump($this->connection->errorInfo());
//            var_dump($stm->errorInfo());

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE data_id = :data_id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':data_id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);

//            var_dump($result);
        }

//        var_dump($result);
        $this->props = $result;
    }


    /**
     * @param int $id
     *
     * @deprecated Add method just to block this getter
     */
    public function getById($id) { }

    /**
     * alias
     */
    public function getId()
    {
        return $this->getDataId();
    }

    /**
     * Primary key
     */
    public function getDataId()
    {
        return $this->getProperty('data_id');
    }

    /**
     * @param string $columnName
     * @param string $columnType, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_BOOL, PDO::PARAM_LOB
     * @param mixed $value
     */
    public function updateProperty($columnName, $columnType, $value)
    {
        $id = $this->getDataId();

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET ' . $columnName . ' = :' . $columnName . ' WHERE data_id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':' . $columnName, $value, $columnType);
            $stm->execute();
        } else {
            var_dump($this);
            echo '!!!['. $columnName .'] ';
            exit;
        }
    }
}