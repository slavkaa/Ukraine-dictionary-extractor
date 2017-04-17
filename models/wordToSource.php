<?php
require_once('abstractModel.php');

class WordToSource extends AbstractModel {

    /**
     * @var string
     */
    protected $tableName = 'word_to_source';

    /**
     * @var mixed[]
     */
    protected $props = [
        'source_id' => null,
        'word_id' => null,
        'counter' => null
    ];

    /**
     * @param integer $sourceId
     * @param integer $wordId
     * @internal param bool $isForeign
     */
    public function firstOrNew($sourceId, $wordId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_id = :word_id AND source_id = :source_id;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word_id', $wordId, PDO::PARAM_INT);
        $stm->bindParam(':source_id', $sourceId, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
//            echo 'U[word2source] ';
        } else {
            echo 'I[word2source] ';
            $sql = 'INSERT INTO `' . $this->tableName . '` (`word_id`, `source_id`) VALUES (:word_id, :source_id );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word_id', $wordId, PDO::PARAM_INT);
            $stm->bindParam(':source_id', $sourceId, PDO::PARAM_INT);
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