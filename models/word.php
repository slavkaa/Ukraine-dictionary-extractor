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
        $sql = 'INSERT INTO `' . $this->tableName . '` (`word`, `is_foreign`) VALUES (:word, :isForeign );';
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
     * @param boolean $isForeign
     */
    public function firstOrNewTotal($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
        $dievidmina, $class, $sub_role, $comparison,$tense, $mood, $is_infinitive, $isForeign = FALSE)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE word = \'' . $word . '\' limit 1;';
        $stm = $this->connection->query($sql);
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $sql = 'INSERT INTO `' . $this->tableName . '` (`word`, `is_foreign`) VALUES (:word, :isForeign );';
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

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }
}