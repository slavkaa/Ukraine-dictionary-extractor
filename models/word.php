<?php
require_once('abstractModel.php');

class Word extends AbstractModel {

    /**
     * @var string
     */
	protected $tableName = 'word';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word' => null,
        'is_main_form' => null,
        'is_proper_name' => null,
        'is_foreign' => null,
        'is_need_processing' => null,
        'part_of_language' => null,
        'genus' => null,
        'number' => null,
        'case' => null,
        'class' => null,
        'sub_role' => null,
        'comparison' => null,
        'tense' => null,
        'mood' => null,
        'is_infinitive' => null,
        'is_modal' => null
    ];

    /**
     * @param string $word
     * @param boolean $isForeign
     */
    public function firstOrNew($word, $isForeign = FALSE)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word = \'' . $word . '\' limit 1;';
        $stm = $this->connection->query($sql);
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[word] ';
        } else {
            echo 'I[word] ';
            $sql = 'INSERT INTO `' . $this->tableName . '` (`word`, `is_foreign`) VALUES (:word, :isForeign );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':isForeign', $isForeign, PDO::PARAM_BOOL);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
//            var_dump($sql);
            $stm->execute();
//            var_dump($stm);
//            var_dump($this->connection->errorInfo());
            $id = $this->connection->lastInsertId();
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