<?php

/**
 * Class WordTrait
 *
 * @property int $id
 * @property PDO $connection
 */
trait WordTrait {
    /**
     * @param string $word
     */
    public function firstOrNewByWordBinary($word)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_binary = \'' . $word . '\' limit 1;';
        $stm = $this->connection->query($sql);
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;

        if (empty($result)) {
            $this->insert($word);
        }
    }

    /**
     * @param string $word
     */
    public function insert($word)
    {
        $sql = 'INSERT INTO `' . $this->tableName . '` (`word`, `word_binary`) VALUES (:word, :word);';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->execute();
        $id = $this->connection->lastInsertId();

//        var_dump($this->connection->errorInfo());
//        var_dump($stm->errorInfo());
//        var_dump($id);

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
    public function findByWord($word)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_binary = \'' . $word . '\' limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
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
        $markers = array_merge($markers, ['=','�','�', '�', '�', '�', '�', '�', '�', '^']);

        return !array_in_string($markers, trim($this->getProperty('word_binary')));
    }

    /**
     * @param string $word
     */
    public function getByWordBinary($word)
    {
        $word = str_replace("'", "\'", $word);

        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_binary = \'' . $word . '\' limit 1;';
        $stm = $this->connection->query($sql);
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->getProperty('word');
    }

    /**
     * @return string
     */
    public function getWordBinary()
    {
        return $this->getProperty('word_binary');
    }
}