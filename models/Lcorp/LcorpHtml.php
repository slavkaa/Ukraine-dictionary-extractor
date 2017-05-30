<?php
require_once(__DIR__ . '\..\Abstract\AbstractDictionaryHtml.php');

class LcorpHtml extends AbstractDictionaryHtml
{
    /**
     * @var string
     */
	protected $tableName = 'lcorp_ulif_org_ua_html';

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
        $extractedHtml = $xpath->query("//*[@id='article_full']");

//        var_dump($extractedHtml); die;

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

    /**
     *
     */
    public function getPartOfLanguage()
    {
        // load extracted HTML=page
        $text = $this->getProperty('html_cut');

        // init HTML parser
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';
        @$doc->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8'));

        // extract table
        $xpath = new DOMXpath($doc);

        /** @var DOMNodeList $extractedHtml */
        $extractedHtml = $xpath->query("//*[@class='gram_style']");
//        $extractedHtml = $xpath->query("//*[@class='gram_style']");

//        var_dump($extractedHtml);

        // combine mini-HTML
        $element = $extractedHtml->item(0);
        $element = $element->textContent;
        $element = trim($element);
        $element = str_replace('– ', '', $element);

        $element = iconv(mb_detect_encoding($element, mb_detect_order(), true), "UTF-8", $element);

        return $element;
    }
}