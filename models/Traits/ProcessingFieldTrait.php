<?php

trait ProcessingFieldTrait {
    /**
     * @param int $limit
     * @return PDOStatement
     */
    public function getAllIsNeedProcessingOrdered($limit = 1000000)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE is_need_processing = 1 ORDER BY id LIMIT :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->execute();

        return $stm;
    }

    /**
     * @param int $limit
     * @return PDOStatement
     */
    public function getAllIsNeedProcessing($limit = 1000000)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE is_need_processing = 1 LIMIT :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->execute();

        return $stm;
    }

    /**
     *
     */
    public function getFirstToProcess() {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE is_need_processing = 1 order by id ASC limit 1;';
        $stm = $this->connection->query($sql);
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            $this->id = array_get($result, 'id');
            $this->props = $result;
        }
    }

    /**
     * @return integer|null
     */
    public function countIsNeedProcessing()
    {
        $sql = 'SELECT count(*) FROM `' . $this->tableName . '` WHERE is_need_processing = 1;';

        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return is_array($result) ? (int) reset($result) : null;
    }

    /**
     *
     */
    public function resetProcessing()
    {
        $sql = 'UPDATE `' . $this->tableName . '` SET is_need_processing = 0 where';
        $sql .= ' is_need_processing = 1;';

        $this->connection->query($sql);
    }
}