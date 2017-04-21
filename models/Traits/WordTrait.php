<?php

trait WordTrait {
    /**
     * @param string $word
     * @param boolean $isForeign
     */
    public function firstOrNew($word, $isForeign = FALSE)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_binary = \'' . $word . '\' limit 1;';
        $stm = $this->connection->query($sql);
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $this->insert($word, $isForeign);
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     * @param string $word
     * @param boolean $isForeign
     */
    public function insert($word, $isForeign = FALSE)
    {
        $sql = 'INSERT INTO `' . $this->tableName . '` (`word`, `word_binary`) VALUES (:word, :word);';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':isForeign', $isForeign, PDO::PARAM_BOOL);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->execute();
        $id = $this->connection->lastInsertId();

        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':id', $id);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     * @param string $word
     */
    public function findByWordAll($word)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_binary = \'' . $word . '\' limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->execute();

        return $stm;
    }

    /**
     * @param string[] $numbers
     * @param string[] $foreignLetters
     *
     * @return bool
     */
    public function isUkraineWord($numbers, $foreignLetters)
    {
        $markers = array_merge($numbers, $foreignLetters);
        $markers = array_merge($markers, ['=','ý','Ý', 'Ú', 'ú', 'Û', 'û', '¨', '¸', '^']);

        return !array_in_string($markers, trim($this->getProperty('word_binary')));
    }
}