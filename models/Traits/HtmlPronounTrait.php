<?php

/**
 * Займенник
 */
trait HtmlPronounTrait {

    /**
     * @param string $word
     * @param string $kind
     * @param string $number
     * @param string $genus
     * @param integer $dictionaryId
     */
    public function firstOrNewPronoun($word, $kind, $number, $genus, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'займенник\' AND word_binary = :word AND kind = :kind AND number = :number AND genus = :genus;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
        $stm->bindParam(':number', $number, PDO::PARAM_STR);
        $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `kind`, `number`, `genus`) VALUES (:dictionary_id, :word, :word, \'займенник\', :kind, :number, :genus);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
            $stm->execute();
            $id = $this->connection->lastInsertId();

//            var_dump($sql);
//            var_dump($stm);
//            var_dump($this->connection->errorInfo());
//            var_dump([$url, $word, $dictionaryId, $wordId]);
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