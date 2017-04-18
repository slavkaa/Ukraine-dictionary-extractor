<?php
require_once('abstractModel.php');

class Source extends AbstractModel {

    /**
     * @var string
     */
    protected $tableName = 'source';

    /**
     * @var mixed[]
     */
    protected $props = [
        'author' => null,
        'title' => null,
    ];

    /**
     * @param string $author
     * @param string $title
     * @internal param bool $isForeign
     */
    public function firstOrNew($author, $title)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE author = :author AND title = :title;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':author', $author, PDO::PARAM_STR);
        $stm->bindParam(':title', $title, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $sql = 'INSERT INTO `' . $this->tableName . '` (`author`, `title`) VALUES (:author, :title );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':author', $author, PDO::PARAM_STR);
            $stm->bindParam(':title', $title, PDO::PARAM_STR);
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