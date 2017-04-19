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
}