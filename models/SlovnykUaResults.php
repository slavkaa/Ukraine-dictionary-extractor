<?php
require_once('abstractModel.php');
require_once('Traits\ProcessingFieldTrait.php');

class SlovnykUaResults extends AbstractModel {

    use ProcessingFieldTrait;

    /**
     * @var string
     */
	protected $tableName = 'slovnyk_ua_results';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word_id' => null,
        'word' => null,
        'word_binary' => null,
        'url' => null,
        'url_binary' => null,
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
     * @param string $part_of_language
     * @param string $creature
     * @param string $genus
     * @param string $number
     * @param string $person
     * @param string $kind
     * @param string $verb_kind
     * @param string $dievidmina
     * @param string $class
     * @param string $sub_role
     * @param string $comparison
     * @param string $tense
     * @param string $mood
     * @param boolean $is_infinitive
     * @param boolean $is_main_form
     * @param string $variation
     */
    public function firstOrNewTotal($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
        $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation)
    {
        $array = [
            'word = :word',
            'word_binary = :word',
            'part_of_language = :part_of_language',
            'creature = :creature',
            'genus = :genus',
            'number = :number',
            'person = :person',
            'kind = :kind',
            'verb_kind = :verb_kind',
            'dievidmina = :dievidmina',
            'class = :class',
            'sub_role = :sub_role',
            'comparison = :comparison',
            'tense = :tense',
            'variation = :variation',
            'mood = :mood',
            'is_infinitive = :is_infinitive',
            'is_main_form = :is_main_form',

        ];

        if (null === $word || null === $part_of_language || null === $creature || null === $genus || null === $number ||
            null === $person || null === $kind || null === $verb_kind || null === $dievidmina || null === $class ||
            null === $sub_role || null === $comparison || null === $tense || null === $mood || !in_array($is_infinitive, [0,1,false,true]) ||
            !in_array($is_main_form, [0,1,false,true]) || null === $variation) {
            var_dump($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation);
            die('NULL value!');
        }

        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE ' . implode(' AND ', $array) . ' limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':part_of_language', $part_of_language, PDO::PARAM_STR);
        $stm->bindParam(':creature', $creature, PDO::PARAM_STR);
        $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
        $stm->bindParam(':number', $number, PDO::PARAM_STR);
        $stm->bindParam(':person', $person, PDO::PARAM_STR);
        $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
        $stm->bindParam(':verb_kind', $verb_kind, PDO::PARAM_STR);
        $stm->bindParam(':dievidmina', $dievidmina, PDO::PARAM_STR);
        $stm->bindParam(':class', $class, PDO::PARAM_STR);
        $stm->bindParam(':sub_role', $sub_role, PDO::PARAM_STR);
        $stm->bindParam(':comparison', $comparison, PDO::PARAM_STR);
        $stm->bindParam(':tense', $tense, PDO::PARAM_STR);
        $stm->bindParam(':mood', $mood, PDO::PARAM_STR);
        $stm->bindParam(':variation', $variation, PDO::PARAM_STR);
        $stm->bindParam(':is_infinitive', $is_infinitive, PDO::PARAM_BOOL);
        $stm->bindParam(':is_main_form', $is_main_form, PDO::PARAM_BOOL);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

//        var_dump($result);
//        var_dump($stm->errorInfo());
//        var_dump($this->connection->errorInfo());
//        var_dump($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
//            $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $dictionary_id);

        if (empty($result)) {

//            var_dump($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
//                $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $dictionary_id);
//            var_dump($result);
//            var_dump($stm->errorInfo());
//            var_dump($this->connection->errorInfo());
//            die;

            $fields = '`word`,`word_binary`,`part_of_language`,`creature`,`genus`,`number`,`person`,`kind`,`verb_kind`,`dievidmina`,`class`,`sub_role`,`comparison`,`tense`,`mood`,`is_infinitive`,`is_main_form`,`variation`';

            $values = ':word,:word,:part_of_language,:creature,:genus,:number,:person,:kind,:verb_kind,:dievidmina,:class,:sub_role,:comparison,:tense,:mood,:is_infinitive,:is_main_form,:variation';

            $sql = 'INSERT INTO `' . $this->tableName . '` (' . $fields . ') VALUES (' . $values . ');';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':part_of_language', $part_of_language, PDO::PARAM_STR);
            $stm->bindParam(':creature', $creature, PDO::PARAM_STR);
            $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->bindParam(':person', $person, PDO::PARAM_STR);
            $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
            $stm->bindParam(':verb_kind', $verb_kind, PDO::PARAM_STR);
            $stm->bindParam(':dievidmina', $dievidmina, PDO::PARAM_STR);
            $stm->bindParam(':class', $class, PDO::PARAM_STR);
            $stm->bindParam(':sub_role', $sub_role, PDO::PARAM_STR);
            $stm->bindParam(':comparison', $comparison, PDO::PARAM_STR);
            $stm->bindParam(':tense', $tense, PDO::PARAM_STR);
            $stm->bindParam(':mood', $mood, PDO::PARAM_STR);
            $stm->bindParam(':variation', $variation, PDO::PARAM_STR);
            $stm->bindParam(':is_infinitive', $is_infinitive, PDO::PARAM_BOOL);
            $stm->bindParam(':is_main_form', $is_main_form, PDO::PARAM_BOOL);
            $stm->execute();

//            var_dump($stm->errorInfo());
//            var_dump($this->connection->errorInfo());
//
//            die;

            $id = $this->connection->lastInsertId();
            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);
        } else {
            echo 'e';
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;

//        if (null === $this->id) {
//            var_dump($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
//                $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $dictionary_id);
//            var_dump($stm->errorInfo());
//            var_dump($this->connection->errorInfo());
//
//            exit;
//        }

//        var_dump($this->id);
//        die;
    }
}