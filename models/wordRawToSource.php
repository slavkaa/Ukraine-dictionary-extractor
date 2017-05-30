<?php
require_once('Abstract\AbstractModel.php');

class WordRawToSource extends AbstractModel {

    /**
     * @var string
     */
    protected $tableName = 'word_raw_to_source';

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
     * @param integer $wordRawId
     */
    public function firstOrNew($sourceId, $wordRawId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_raw_id = :word_raw_id AND source_id = :source_id;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word_raw_id', $wordRawId, PDO::PARAM_INT);
        $stm->bindParam(':source_id', $sourceId, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $sql = 'INSERT INTO `' . $this->tableName . '` (`word_raw_id`, `source_id`) VALUES (:word_raw_id, :source_id );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word_raw_id', $wordRawId, PDO::PARAM_INT);
            $stm->bindParam(':source_id', $sourceId, PDO::PARAM_INT);
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
}