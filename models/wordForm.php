<?php
require_once('abstractModel.php');

class WordForm extends AbstractModel {
    /**
     * @var string
     */
    protected $tableName = 'word_form';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word_main_form_id' => null,
        'related_word_id' => null
    ];

    /**
     * @param integer $mainFormId
     * @param integer $relatedFormId
     */
    public function firstOrNew($mainFormId, $relatedFormId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word_main_form_id = :word_main_form_id AND related_word_id = :related_word_id limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word_main_form_id', $mainFormId, PDO::PARAM_INT);
        $stm->bindParam(':related_word_id', $relatedFormId, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            $this->isNew = false;
            echo 'U[word2ignore] ';
        } else {
            $this->isNew = true;
            echo 'U[word2ignore] ';
            $sql = 'INSERT INTO `' . $this->tableName . '` (` word_main_form_id`, `related_word_id`) VALUES (:word_main_form_id, :related_word_id );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word_main_form_id', $mainFormId, PDO::PARAM_INT);
            $stm->bindParam(':related_word_id', $relatedFormId, PDO::PARAM_INT);
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