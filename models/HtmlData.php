<?php
require_once('abstractModel.php');

class HtmlData extends AbstractModel {

    /**
     * @var string
     */
	protected $tableName = 'html_data';

    /**
     * @var mixed[]
     */
    protected $props = [
        'html_id' => null,
        'word' => null,
        'word_binary' => null,
        'html' => null,
        'html_cut' => null,
    ];

    /**
     *
     */
    public function getByHtmlId($id)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE html_id = :id;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

//        var_dump($result);
//        var_dump($this->connection->errorInfo());
//        var_dump($stm->errorInfo());

        $this->props = $result;
    }

    /**
     * @param string $htmlId
     * @param string $word
     */
    public function firstOrNew($htmlId, $word)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE html_id = :html_id limit 1;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':html_id', $htmlId, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

//        var_dump($htmlId, $word);
//        var_dump($sql);
//        var_dump($result);
//        var_dump($this->connection->errorInfo());
//        var_dump($stm->errorInfo());

        if (empty($result) || false === $result) {


            $sql = 'INSERT INTO `' . $this->tableName .
                '` ( `html_id`, `word`, `word_binary`) VALUES (:html_id, :word, :word );';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':word', $word, PDO::PARAM_STR);
            $stm->bindParam(':html_id', $htmlId, PDO::PARAM_INT);
            $stm->execute();

            $id = $htmlId; // there is no primary key here

//            var_dump($sql);
//            var_dump($id);
//            var_dump($this->connection->errorInfo());
//            var_dump($stm->errorInfo());

            $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE html_id = :html_id limit 1;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':html_id', $id);
            $stm->execute();
            $result = $stm->fetch(PDO::FETCH_ASSOC);

//            var_dump($result);
        }

//        var_dump($result);
        $this->props = $result;
    }

    /**
     * @param int $id
     * @deprecated
     */
    public function getById($id) { }

    /**
     * alias
     */
    public function getId()
    {
        return $this->getHtmlId();
    }

    /**
     * Primary key
     */
    public function getHtmlId()
    {
        return $this->getProperty('html_id');
    }

    /**
     * Generate html_cut from html
     */
    public function generateCutHtml()
    {
        // load extracted HTML=page
        $text = $this->getProperty('html');
        $text = iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);

        // init HTML parser
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';
        @$doc->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8'));

        // extract table
        $xpath = new DOMXpath($doc);

        /** @var DOMNodeList $partOfLanguageData */
        $partOfLanguageData = $xpath->query("//*[contains(@class, 'sfm_table')]");

        // combine mini-HTML
        $element = $partOfLanguageData->item(0);

        if (NULL === $element) {
            // do nothing
            echo '-'.$this->getProperty('html_id').':'.$this->getProperty('word_binary');
        } else {
            $newDoc = new DOMDocument();
            $doc->encoding = 'UTF-8';
            $cloned = $element->cloneNode(TRUE);
            $newDoc->appendChild($newDoc->importNode($cloned, TRUE));

            // update html_cut
            $this->updateProperty('html_cut', PDO::PARAM_LOB, html_entity_decode($newDoc->saveHTML()));

            echo '+';
        }
    }

    /**
     * @param string $columnName
     * @param string $columnType, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_BOOL, PDO::PARAM_LOB
     * @param mixed $value
     */
    public function updateProperty($columnName, $columnType, $value)
    {
        $id = $this->getHtmlId();

        if ($id) {
            $sql = 'UPDATE `' . $this->tableName . '` SET ' . $columnName . ' = :' . $columnName . ' WHERE html_id = :id;';
            $stm = $this->connection->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':' . $columnName, $value, $columnType);
            $stm->execute();
        } else {
            var_dump($this);
            echo '!!!['. $columnName .'] ';
            exit;
        }
    }
}