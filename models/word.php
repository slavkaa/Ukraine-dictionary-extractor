<?php
require_once('abstractModel.php');
require_once('Traits\ProcessingFieldTrait.php');
require_once('Traits\WordTrait.php');

class Word extends AbstractModel
{
    use ProcessingFieldTrait, WordTrait;

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
     * @param string $variation
     * @param string $mood
     * @param boolean $is_infinitive
     * @param boolean $is_main_form
     * @param string $main_form_code
     */
    public function firstOrNewTotal($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
        $dievidmina, $class, $sub_role, $comparison, $tense, $variation, $mood, $is_infinitive, $is_main_form, $main_form_code)
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
        $stm->bindParam(':variation', $variation, PDO::PARAM_STR);
        $stm->bindParam(':mood', $mood, PDO::PARAM_STR);
        $stm->bindParam(':is_infinitive', $is_infinitive, PDO::PARAM_BOOL);
        $stm->bindParam(':is_main_form', $is_main_form, PDO::PARAM_BOOL);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {

            $fields = '`word`,`word_binary`,`part_of_language`,`creature`,`genus`,`number`,`person`,`kind`,`verb_kind`,`dievidmina`,'
                .'`class`,`sub_role`,`comparison`,`tense`,`mood`,`is_infinitive`,`is_main_form`, `variation`,`unique_code`,`main_form_code`';

            $values = ':word,:word,:part_of_language,:creature,:genus,:number,:person,:kind,:verb_kind,:dievidmina,'.
                ':class,:sub_role,:comparison,:tense,:mood,:is_infinitive,:is_main_form,:variation,:unique_code,:main_form_code';


            $unique_code = implode(';', [
                $word, $main_form_code, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                $dievidmina, $class, $sub_role, $comparison, $tense, $variation, $mood, $is_infinitive, $is_main_form
            ]);

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
            $stm->bindParam(':variation', $variation, PDO::PARAM_STR);
            $stm->bindParam(':mood', $mood, PDO::PARAM_STR);
            $stm->bindParam(':unique_code', $unique_code, PDO::PARAM_STR);
            $stm->bindParam(':main_form_code', $main_form_code, PDO::PARAM_STR);
            $stm->bindParam(':is_infinitive', $is_infinitive, PDO::PARAM_BOOL);
            $stm->bindParam(':is_main_form', $is_main_form, PDO::PARAM_BOOL);
            $stm->execute();

//            var_dump($part_of_language);
//            var_dump($stm->errorInfo());

            $id = $this->connection->lastInsertId();

            if ($id) {
                echo 'NEW';
            } else {
                echo 'Error' . "\n\n";
                var_dump($word);
                var_dump($array);
                var_dump($part_of_language);
                var_dump($stm->errorInfo());

                die;
            }

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);

            $this->id = array_get($result, 'id');
            $this->props = $result;
        } else {
            $this->id = array_get($result, 'id');
            $this->props = $result;

            $this->updateProperty('main_form_code', PDO::PARAM_STR, $main_form_code);
            $this->updateUniqueCode($word, $main_form_code, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                $dievidmina, $class, $sub_role, $comparison, $tense, $variation, $mood, $is_infinitive, $is_main_form);

            echo 'e';
        }
    }


    /**
     * @param string $word
     * @param string $main_form_code
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
     * @param string $variation
     * @param string $mood
     * @param boolean $is_infinitive
     * @param boolean $is_main_form
     */
    public function updateUniqueCode($word, $main_form_code, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
        $dievidmina, $class, $sub_role, $comparison, $tense, $variation, $mood, $is_infinitive, $is_main_form)
    {
        $unique_code = implode(';', [
            $word, $main_form_code, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
            $dievidmina, $class, $sub_role, $comparison, $tense, $variation, $mood, $is_infinitive, $is_main_form
        ]);

        $this->updateProperty('unique_code', PDO::PARAM_STR, $unique_code);
    }

    /**
     * @param string $word
     *
     * @return string
     */
    public static function cleanWord($word)
    {
        $word = str_replace('на/у ', '', $word);

        return $word;
    }
}