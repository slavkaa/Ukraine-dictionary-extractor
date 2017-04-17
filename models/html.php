<?php
require_once('abstractModel.php');
require_once('Traits\HtmlNounTrait.php');
require_once('Traits\HtmlAdjectiveTrait.php');
require_once('Traits\HtmlVerbTrait.php');
require_once('Traits\HtmlPrepositionTrait.php');
require_once('Traits\HtmlPronounTrait.php');
require_once('Traits\HtmlConjunctionTrait.php');
require_once('Traits\HtmlParticleTrait.php');
require_once('Traits\HtmlAdverbTrait.php');

class Html extends AbstractModel {

    use HtmlNounTrait, HtmlAdjectiveTrait, HtmlVerbTrait, HtmlPrepositionTrait, HtmlPronounTrait,
        HtmlConjunctionTrait, HtmlParticleTrait, HtmlAdverbTrait;

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
}