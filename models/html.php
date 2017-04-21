<?php
require_once('abstractModel.php');
require_once('Traits\ProcessingFieldTrait.php');

class Html extends AbstractModel {

    use ProcessingFieldTrait;

    /**
     * @var string
     */
	protected $tableName = 'html';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word_id' => null,
        'word' => null,
        'word_binary' => null,
        'url' => null,
        'url_binary' => null,
        'html' => null,
        'html_cut' => null,
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
     * @param string $wordId
     * @param string $url
     * @param string $word
     * @param integer $dictionaryId
     */
    public function firstOrNew($wordId, $url, $word, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE url_binary = :url;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':url', $url, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` ( `dictionary_id`, `word_id`, `url`, `url_binary`, `word`, `word_binary`) VALUES (:dictionary_id, :word_id, :url, :url, :word, :word );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':url', $url, PDO::PARAM_STR);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
            $stm->bindParam(':word_id', $wordId, PDO::PARAM_INT);
            $stm->execute();
            $id = $this->connection->lastInsertId();

//            var_dump($sql);
//            var_dump($stm);
//            var_dump($this->connection->errorInfo());
//            var_dump([$url, $word, $dictionaryId, $wordId]);
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

    /**
     *
     */
    public function getMaxFilledHtml()
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE html IS NOT NULL ORDER BY id DESC LIMIT 1;';
        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     *
     */
    public function getFirstFilledHtml()
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE html IS NOT NULL ORDER BY id ASC LIMIT 1;';
        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     * @param int $limit
     * @return PDOStatement
     */
    public function getAllWithoutHtml($limit = 1000000)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE html IS NULL OR html = \'\' LIMIT :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->execute();

        return $stm;
    }

    /**
     * @param string $partOfLanguage
     * @param int $limit
     * @param int $offset
     * @param string $sing
     * @return PDOStatement
     */
    public function getPartOfLanguage($partOfLanguage, $limit = 1000000, $offset = 0, $sing = '=')
    {
        echo "offset $offset, limit $limit \n";

        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language ' . $sing .' :part_of_language and url IS NOT NULL ORDER BY id LIMIT :offset, :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
        $stm->execute();

        return $stm;
    }

    /**
     * @param int $limit
     * @return PDOStatement
     */
    public function getAllWithUndefinedPartOfLanguage($limit = 1000000)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language IS NULL order by id asc LIMIT :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->execute();

        return $stm;
    }

    /**
     * @param string $word
     * @param string $partOfLanguage
     * @param integer $dictionaryId
     */
    public function firstOrNewByPartOfLanguage($word, $partOfLanguage, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = :part_of_language AND word_binary = :word';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`) VALUES (:dictionary_id, :word, :word, :part_of_language);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
            $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
            $stm->execute();
            $id = $this->connection->lastInsertId();

//            var_dump($this->connection->errorInfo());

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

    /**
     * @param string $word
     * @param string $partOfLanguage
     * @param string $kind
     * @param string $number
     * @param string $genus
     * @param integer $dictionaryId
     */
    public function firstOrNewByKingNumeralGenus($word, $partOfLanguage, $kind, $number, $genus, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = :part_of_language AND word_binary = :word AND kind = :kind AND number = :number AND genus = :genus;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
        $stm->bindParam(':number', $number, PDO::PARAM_STR);
        $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
        $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `kind`, `number`, `genus`) VALUES (:dictionary_id, :word, :word, :part_of_language, :kind, :number, :genus);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
            $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
            $stm->execute();
            $id = $this->connection->lastInsertId();

//            var_dump($this->connection->errorInfo());

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE id = :id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);
        }

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }

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
     * @param int $dictionary_id
     */
    public function firstOrNewTotal($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
        $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $dictionary_id)
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
            !in_array($is_main_form, [0,1,false,true]) || null === $variation || null === $dictionary_id) {
            var_dump($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $dictionary_id);
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
        $stm->bindParam(':dictionary_id', $dictionary_id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

//        var_dump($stm->errorInfo());
//        var_dump($this->connection->errorInfo());

        if (empty($result)) {

//            var_dump($word, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
//                $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $dictionary_id);
//            var_dump($result);
//            var_dump($stm->errorInfo());
//            var_dump($this->connection->errorInfo());
//            die;

            $fields = '`word`,`word_binary`,`part_of_language`,`creature`,`genus`,`number`,`person`,`kind`,`verb_kind`,`dievidmina`,`class`,`sub_role`,`comparison`,`tense`,`mood`,`is_infinitive`,`is_main_form`,`variation`,`dictionary_id`';

            $values = ':word,:word,:part_of_language,:creature,:genus,:number,:person,:kind,:verb_kind,:dievidmina,:class,:sub_role,:comparison,:tense,:mood,:is_infinitive,:is_main_form,:variation,:dictionary_id';

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
            $stm->bindParam(':dictionary_id', $dictionary_id, PDO::PARAM_INT);
            $stm->execute();

//            var_dump($stm->errorInfo());
//            var_dump($this->connection->errorInfo());

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