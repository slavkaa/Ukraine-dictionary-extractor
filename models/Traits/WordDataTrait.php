<?php

/**
 * Class WordDataTrait
 *
 * @property int $id
 * @property PDO $connection
 */
trait WordDataTrait
{
    /**
     * @param string $wordId
     * @param string $word
     */
    public function firstOrNew($wordId, $word)
    {
        /** @var AbstractModel $this */

//        var_dump($wordId, $url, $word);

        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_binary = :word limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

//        var_dump($result);
//        var_dump($this->connection->errorInfo());
//        var_dump($stm->errorInfo());

        if (empty($result) || false === $result) {
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`word_id`, `word`, `word_binary`) VALUES (:word_id, :word, :word );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':word_id', $wordId, PDO::PARAM_INT);
            $stm->execute();
            $id = $wordId;

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);

//            var_dump($id);
//            var_dump($this->connection->errorInfo());
//            var_dump($stm->errorInfo());
//            var_dump($result);
        }

        $this->props = $result;
    }

    /**
     *
     */
    public function backRowsToProcessing()
    {
        /** @var AbstractModel $this */

        $sql = 'UPDATE html SET is_need_processing = 1 WHERE url IS NOT NULL;';
        $this->connection->query($sql);
    }

    /**
     * @param string $columnName
     * @param string $columnType, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_BOOL, PDO::PARAM_LOB
     * @param mixed $value
     */
    public function updateProperty($columnName, $columnType, $value)
    {
        /** @var AbstractModel $this */

        $word_id = $this->getProperty('word_id');

        if ($word_id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET `' . $columnName . '` = :' . $columnName . ' WHERE word_id = :word_id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word_id', $word_id, PDO::PARAM_INT);
            $stm->bindParam(':' . $columnName, $value, $columnType);
            $stm->execute();
        } else {
//            var_dump($this);
            echo 'WDT !!!['. $columnName .'] ';
            exit;
        }
    }

    /**
     *
     */
    public function getByWordId($id)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_id = :id;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->props = $result;
    }
}