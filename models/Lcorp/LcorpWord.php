<?php
require_once(__DIR__ . '\..\Abstract\AbstractWord.php');;

class LcorpWord extends AbstractWord
{
    /**
     * @var string
     */
	protected $tableName = 'lcorp_ulif_org_ua_word';


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
     * @param null $main_form_code
     * @param null $data_id
     */
    public function firstOrNewTotal($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                                    $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $main_form_code = null)
    {
        global $accentedLetters, $accentedLettersReplace;

        $array = [
            'accented = :accented',
            'accented_binary = :accented',
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

        $accented = $word;
        $word = clearAttended($word , $accentedLetters, $accentedLettersReplace);

        if (null === $word || null === $part_of_language || null === $creature || null === $genus || null === $number ||
            null === $person || null === $kind || null === $verb_kind || null === $dievidmina || null === $class ||
            null === $sub_role || null === $comparison || null === $tense || null === $mood || !in_array($is_infinitive, [0,1,false,true]) ||
            !in_array($is_main_form, [0,1,false,true]) || null === $variation) {
            var_dump($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $main_form_code);
            die('NULL value!');
        }

        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE ' . implode(' AND ', $array) . ' limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':accented', $accented, PDO::PARAM_STR);
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

        if (empty($result)) {
            $fields = '`word`,`word_binary`,`accented`,`accented_binary`,`part_of_language`,`creature`,`genus`,`number`,`person`,`kind`,`verb_kind`,`dievidmina`,`class`,`sub_role`,`comparison`,`tense`,`mood`,`is_infinitive`,`is_main_form`,`variation`,`main_form_code`,`unique_code`';

            $values = ':word,:word,:accented,:accented,:part_of_language,:creature,:genus,:number,:person,:kind,:verb_kind,:dievidmina,:class,:sub_role,:comparison,:tense,:mood,:is_infinitive,:is_main_form,:variation,:main_form_code,:unique_code';

            $uniqueCode = $this->combineUniqueCode($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation);

            $sql = 'INSERT INTO `' . $this->tableName . '` (' . $fields . ') VALUES (' . $values . ');';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':accented', $accented, PDO::PARAM_STR);
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
            $stm->bindParam(':main_form_code', $main_form_code, PDO::PARAM_STR);
            $stm->bindParam(':is_infinitive', $is_infinitive, PDO::PARAM_BOOL);
            $stm->bindParam(':is_main_form', $is_main_form, PDO::PARAM_BOOL);
            $stm->bindParam(':unique_code', $uniqueCode, PDO::PARAM_STR);
            $stm->execute();

//            var_dump($stm->errorInfo());
//            var_dump($this->connection->errorInfo());
//            die;

            $id = $this->connection->lastInsertId();
            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);

            echo 'n';
        } else {
            echo 'e';
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     * @param $word
     * @param $part_of_language
     * @param $creature
     * @param $genus
     * @param $number
     * @param $person
     * @param $kind
     * @param $verb_kind
     * @param $dievidmina
     * @param $class
     * @param $sub_role
     * @param $comparison
     * @param $tense
     * @param $mood
     * @param $is_infinitive
     * @param $is_main_form
     * @param $variation
     *
     * @return string
     */
    private function combineUniqueCode($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                                       $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation)
    {
        return sprintf(
            '%s_%s_%s_%s_%s_%s_%s_%s_%s_%s_%s_%s_%s_%s_%s_%s_%s_',
            $word,
            $part_of_language,
            $creature,
            $genus,
            $number,
            $person,
            $kind,
            $verb_kind,
            $dievidmina,
            $class,
            $sub_role,
            $comparison,
            $tense,
            $mood,
            (int) $is_infinitive,
            (int) $is_main_form,
            $variation
        );
    }
}