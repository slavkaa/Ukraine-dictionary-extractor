<?php
require_once('abstractModel.php');

class Html extends AbstractModel {

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
     * @param string $word
     * @param string $kind
     * @param string $number
     * @param integer $dictionaryId
     */
    public function firstOrNewImennyk($word, $kind, $number, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'іменник\' AND word_binary = :word AND kind = :kind AND number = :number;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
        $stm->bindParam(':number', $number, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `kind`, `number`) VALUES (:dictionary_id, :word, :word, \'іменник\', :kind, :number);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
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
     * @param string $word
     * @param string $kind
     * @param string $number
     * @param string $genus
     * @param integer $dictionaryId
     */
    public function firstOrNewPrykmetnyk($word, $kind, $number, $genus, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'прикметник\' AND word_binary = :word AND kind = :kind AND number = :number AND genus = :genus;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
        $stm->bindParam(':number', $number, PDO::PARAM_STR);
        $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `kind`, `number`, `genus`) VALUES (:dictionary_id, :word, :word, \'прикметник\', :kind, :number, :genus);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':kind', $kind, PDO::PARAM_STR);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
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
     * @param string $infinitive
     * @param string $verbKind
     * @param string $dievidmina
     * @param integer $dictionaryId
     */
    public function firstOrNewInfinitive($infinitive, $verbKind, $dievidmina, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'дієслово\' AND word_binary = :word AND verb_kind = :kind AND dievidmina = :dievidmina;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $infinitive, PDO::PARAM_STR);
        $stm->bindParam(':kind', $verbKind, PDO::PARAM_STR);
        $stm->bindParam(':dievidmina', $dievidmina, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `verb_kind`, `dievidmina`) VALUES (:dictionary_id, :word, :word, \'дієслово\', :kind, :dievidmina);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $infinitive, PDO::PARAM_STR);
            $stm->bindParam(':kind', $verbKind, PDO::PARAM_STR);
            $stm->bindParam(':dievidmina', $dievidmina, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
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
     * @param string $word
     * @param string $tense
     * @param string $number
     * @param string $genus
     * @param string $person
     * @param integer $dictionaryId
     */
    public function firstOrNewVerb($word, $tense, $number, $genus, $person, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'дієслово\' AND word_binary = :word AND tense = :tense AND number = :number AND genus = :genus AND person = :person;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':tense', $tense, PDO::PARAM_STR);
        $stm->bindParam(':number', $number, PDO::PARAM_STR);
        $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
        $stm->bindParam(':person', $person, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `tense`, `number`, `genus`, `person`) VALUES (:dictionary_id, :word, :word, \'дієслово\', :tense, :number, :genus, :person);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':tense', $tense, PDO::PARAM_STR);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
            $stm->bindParam(':person', $person, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
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
     * @param string $word
     * @param string $tense
     * @param integer $dictionaryId
     */
    public function firstOrNewDiepruslivnyk($word, $tense, $dictionaryId)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'дієслово\' AND word_binary = :word AND tense = :tense;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->bindParam(':tense', $tense, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            echo 'U[html] ';
        } else {
            echo 'I[html] ';
            $sql = 'INSERT INTO `' . $this->tableName .
                '` (`dictionary_id`,`word`, `word_binary`, `part_of_language`, `tense`) VALUES (:dictionary_id, :word, :word, \'дієслово\', :tense);';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':tense', $tense, PDO::PARAM_STR);
            $stm->bindParam(':dictionary_id', $dictionaryId, PDO::PARAM_INT);
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
     * @param string $html
     */
    public function updateHtml($html)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET html = :html WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':html', $html, PDO::PARAM_LOB);
            $stm->execute();

            echo 'U[html:' . $id . '] ';
        } else {
            echo '!!![html] ';
        }

//        var_dump($this->connection->errorInfo());
    }

    /**
     * @param string $url
     */
    public function updateUrl($url)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET url = :url, url_binary = :url WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':url', $url, PDO::PARAM_STR);
            $stm->execute();

            echo 'U[html:' . $id . '] ';
        } else {
            echo '!!![html] ';
        }
    }

    /**
     * @param boolean $isNeedProcessing
     */
    public function updateIsNeedProcessing($isNeedProcessing)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET is_need_processing = :is_need_processing WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':is_need_processing', $isNeedProcessing, PDO::PARAM_BOOL);
            $stm->execute();

            echo 'U[inp:' . $id . '] ';
        } else {
            echo '!!![inp] ';
        }
    }

    /**
     * @param string $html
     */
    public function updateHtmlCut($html)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET html_cut = :html WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':html', $html, PDO::PARAM_STR);
            $stm->execute();

            echo 'U[html_cut:' . $id . '] ';
        } else {
            echo '!!![html] ';
        }
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
     * @param int $limit
     * @return PDOStatement
     */
    public function getAllIsNeedProcessing($limit = 1000000)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE is_need_processing = 1 ORDER BY id LIMIT :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->execute();

        return $stm;
    }

//    /**
//     * @param int $limit
//     * @return PDOStatement
//     */
//    public function getImennyk($limit = 1000000)
//    {
//        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'іменник\' ORDER BY id LIMIT :limit;';
//        $stm = $this->connection->prepare($sql);
//        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
//        $stm->execute();
//
//        return $stm;
//    }

    /**
     * @param string $partOfLanguage
     * @param int $limit
     * @param int $offset
     * @param string $sing
     * @return PDOStatement
     */
    public function getPartOfLanguage($partOfLanguage, $limit = 1000000, $offset = 0, $sing = '=')
    {
        echo "\n offset $offset, limit $limit \n";

        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language ' . $sing .' :part_of_language ORDER BY id LIMIT :offset, :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
        $stm->execute();

        return $stm;
    }

    /**
     * @param string  $partOfLanguage
     */
    public function updatePartOfLanguage($partOfLanguage)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET part_of_language= :part_of_language WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
            $stm->execute();

            echo 'U[pof:' . $id . '] ';
        } else {
            echo '!!![pof] ';
        }
    }

    /**
     * @param string $creature
     */
    public function updateCreature($creature)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET is_creature = :is_creature WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':is_creature', $creature, PDO::PARAM_BOOL);
            $stm->execute();

            echo 'U[Creature:' . $id . '] ';
        } else {
            echo '!!![Creature] ';
        }
    }

    /**
     * @param string $genus
     */
    public function updateGenus($genus)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET genus = :genus WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':genus', $genus, PDO::PARAM_STR);
            $stm->execute();

            echo 'U[genus:' . $id . '] ';
        } else {
            echo '!!![genus] ';
        }
    }

    /**
     * @param string $variation
     */
    public function updateVariation($variation)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET variation = :variation WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':variation', $variation, PDO::PARAM_STR);
            $stm->execute();

            echo 'U[variation:' . $id . '] ';
        } else {
            echo '!!![variation] ';
        }
    }

    /**
     * @param boolean $isMainForm
     */
    public function updateIsMainForm($isMainForm)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET is_main_form = :isMainForm WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':isMainForm', $isMainForm, PDO::PARAM_BOOL);
            $stm->execute();

            echo 'U[isMainForm:' . $id . '] ';
        } else {
            echo '!!![isMainForm] ';
        }
    }

    /**
     * @param boolean $number
     */
    public function updateNumber($number)
    {
        $id = (int) array_get($this->props, 'id');

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET number = :number WHERE id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':number', $number, PDO::PARAM_STR);
            $stm->execute();

            echo 'U[number:' . $id . '] ';
        } else {
            echo '!!![number] ';
        }
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
     */
    public function getImennykByWord($word)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language = \'іменник\' word_binary = :word;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':word', $word, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }
}