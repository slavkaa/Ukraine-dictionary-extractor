<?php
require_once('AbstractModel.php');
require_once(__DIR__ . '/../Traits/ProcessingFieldTrait.php');
require_once(__DIR__ . '/../Traits/ParserHtmlTrait.php');
require_once(__DIR__ . '/../Traits/WordTrait.php');

class AbstractDictionaryHtml extends AbstractModel {

    use ParserHtmlTrait, WordTrait, ProcessingFieldTrait;

    /**
     * @var string
     */
	protected $tableName = null;

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
     * @param string $page, HTML code
     *
     * Generate html_cut from html
     */
    public function generateCutHtml($page)
    {
        // load extracted HTML=page
        $text = $page;
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
            echo 'NULL'; //.$this->getProperty('data_id').':'.$this->getProperty('word_binary');
        } else {
            $newDoc = new DOMDocument();
            $doc->encoding = 'UTF-8';
            $cloned = $element->cloneNode(TRUE);
            $newDoc->appendChild($newDoc->importNode($cloned, TRUE));

            // update html_cut
            $this->updateProperty('html_cut', PDO::PARAM_LOB, html_entity_decode($newDoc->saveHTML()));

            echo 'CUT';
        }
    }
}