<?php
require_once(__DIR__ . '\..\Abstract\AbstractDictionaryHtml.php');

class WwdHtml extends AbstractDictionaryHtml
{
    /**
     * @var string
     */
	protected $tableName = 'worldwidedictionary_org_html';

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

        /** @var DOMNodeList $extractedHtml */
        $extractedHtml = $xpath->query("//*[@class='word']");

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