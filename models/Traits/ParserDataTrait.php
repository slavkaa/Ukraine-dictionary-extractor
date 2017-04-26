<?php

trait ParserDataTrait
{
    /**
     * @param string $wordId
     * @param string $word
     */
    public function firstOrNew($wordId, $word)
    {
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
            $id = $this->connection->lastInsertId();

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);

//            var_dump($id);
//            var_dump($this->connection->errorInfo());
//            var_dump($stm->errorInfo());
//            var_dump($result);
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     *
     */
    public function backRowsToProcessing()
    {
        $sql = 'UPDATE html SET is_need_processing = 1 WHERE url IS NOT NULL;';
        $this->connection->query($sql);
    }
}