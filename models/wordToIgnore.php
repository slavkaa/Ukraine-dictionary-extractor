<?php
require_once('abstractModel.php');

class WordToIgnore extends AbstractModel {
    /**
     * @var string
     */
    protected $tableName = 'word_to_ignore';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word' => null,
        'is_false_alert' => null
    ];

    /**
     * @param string $word
     * @param integer $sourceId
     * @internal param bool $isForeign
     */
    public function firstOrNew($word, $sourceId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word = \'' . $word . '\' limit 1;';
        $stm = $this->connection->query($sql);
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            $this->isNew = false;
            echo 'U[word2ignore] ';
        } else {
            $this->isNew = true;
            echo 'U[word2ignore] ';
            $sql = 'INSERT INTO `' . $this->tableName . '` (`word`, `word_readable`, `source_id`) VALUES (:word, :word, :source_id );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':source_id', $sourceId, PDO::PARAM_INT);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
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
//        var_dump($result);
    }
}