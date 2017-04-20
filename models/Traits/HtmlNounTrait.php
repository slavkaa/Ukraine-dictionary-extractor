<?php

/**
 * Іменник
 */
trait HtmlNounTrait {

    /**
     * @param string $word
     * @param string $kind
     * @param string $number
     * @param integer $dictionaryId
     */
    public function firstOrNewImennyk($word, $kind, $number, $dictionaryId)
    {
        $this->firstOrNewNoun($word, $kind, $number, $dictionaryId);
    }

    /**
     * @param string $word
     * @param string $kind
     * @param string $number
     * @param integer $dictionaryId
     */
    public function firstOrNewNoun($word, $kind, $number, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'іменник\' AND word_binary = :word AND kind = :kind AND number = :number;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
        $stm->bindParam(':number', $number, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `kind`, `number`) VALUES (:dictionary_id, :word, :word, \'іменник\', :kind, :number);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
            $stm->execute();
            $id = $this->connection->lastInsertId();

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     * @param string $word
     */
    public function getImennykByWord($word)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'іменник\' word_binary = :word;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     * @param string $word
     * @param string $kind
     * @param string $number
     * @param integer $dictionaryId
     * @param string $creature
     * @param string $genus
     * @param string $variation
     * @param boolean $isMainForm
     */
    public function firstOrNewNounNonUrl($word, $kind, $number, $dictionaryId, $creature, $genus, $variation, $isMainForm)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'іменник\' AND word_binary = :word AND '.
            'kind = :kind AND number = :number AND url is NULL AND creature = :creature AND genus = :genus AND variation = :variation AND is_main_form = :isMainForm LIMIT 1;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
        $stm->bindParam(':number', $number, PDO::PARAM_STR);
        $stm->bindParam(':creature', $creature, PDO::PARAM_STR);
        $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
        $stm->bindParam(':variation', $variation, PDO::PARAM_STR);
        $stm->bindParam(':isMainForm', $isMainForm, PDO::PARAM_BOOL);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        var_dump($stm->errorInfo());

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `kind`, `number`, `creature`, `genus`, `variation`, `isMainForm`) '.
                ' VALUES (:dictionary_id, :word, :word, \'іменник\', :kind, :number, :creature, :genus, :variation, :is_main_form);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
            $stm->bindParam(':creature', $creature, PDO::PARAM_STR);
            $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
            $stm->bindParam(':variation', $variation, PDO::PARAM_STR);
            $stm->bindParam(':isMainForm', $isMainForm, PDO::PARAM_BOOL);
            $stm->execute();
            $id = $this->connection->lastInsertId();

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;

        die;
    }
} 