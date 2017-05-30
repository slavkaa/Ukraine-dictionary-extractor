<?php
require_once('Abstract\AbstractModel.php');
require_once('Traits/ParserHtmlTrait.php');

class SumInUaHtml extends AbstractModel {

    use ParserHtmlTrait;

    /**
     * @var string
     */
	protected $tableName = 'sum_in_ua_html';

    /**
     * @var mixed[]
     */
    protected $props = [
        'data_id' => null,
        'word' => null,
        'word_binary' => null,
        'html' => null,
        'html_cut' => null,
    ];

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

        /** @var DOMNodeList $extractedHtml */
        $extractedHtml = $xpath->query("//*[@id='article']/div");

        // combine mini-HTML
        $element = $extractedHtml->item(0);

        if (NULL === $element) {
            // do nothing
            echo '-'.$this->getProperty('data_id').':'.$this->getProperty('word_binary');
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
}