<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_handle_woman_name.php

require_once('../support/config.php');
require_once('../support/functions.php');
require_once('../support/libs.php');
require_once('../models/word.php');
require_once('../models/wordToIgnore.php');
require_once('../models/source.php');
require_once('../models/dictionary.php');
require_once('../models/html.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

$part_of_language = 'жіноче ім\'я';
echo "\n";

for ($j = 0; $j < 1;  $j++) {
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%' . $part_of_language . '%', 100, $j*100, 'LIKE');
    echo "<";

    foreach ($allHtml as $htmlArray) {
        echo '+';
        /** @var Html $html */
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        // load extracted HTML=page
        $text = cleanCyrillic($html->getProperty('html_cut'));
        $text = str_replace(
            ['sfm_cell_1s', 'sfm_cell_2s', 'sfm_cell_1_x2', 'sfm_cell_1e_x2', 'sfm_cell_1e', 'sfm_cell_2_x2', 'sfm_cell_2e_x2', 'sfm_cell_2e'],
            ['sfm_cell_v',  'sfm_cell_v',  'sfm_cell_1',    'sfm_cell_e_1',   'sfm_cell_e_1',   'sfm_cell_2',    'sfm_cell_2e', 'sfm_cell_e_2'],
            $text);
        $url = $html->getProperty('url');

        // filtrate noun {
        // init HTML parser
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';
        @$doc->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8'));

        // extract tables
        $xpath = new DOMXpath($doc);
        $tables = $xpath->query("//*[contains(@class, 'sfm_table')]");

        $isFound = false;
        for ($i = 0; $i < $tables->length; $i++) {
            $item = $tables->item($i);
            if (-1 < strpos($item->textContent, $part_of_language)) {
                $doc = new DOMDocument();
                @$doc->loadHTML(mb_convert_encoding($item->ownerDocument->saveHTML($item), 'HTML-ENTITIES', 'UTF-8'));
                $isFound = true;

                $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
                break;
            }
        }

        if (!$isFound) {

            $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }
        // filtrate noun }

        // extract table
        $xpath = new DOMXpath($doc);
        /** @var DOMNodeList $partOfLanguageData */
        $definition = $xpath->query("//*[contains(@class, 'sfm_cell_hx')]");
        $definition = $definition->item(0)->textContent;
        $definition = explode('(', $definition);

        $class = str_replace([')', ' '], '', array_get($definition, 1));

        $cell1 = $xpath->query("//*[contains(@class, 'sfm_cell_1')]");
        $cell1e = $xpath->query("//*[contains(@class, 'sfm_cell_e_1')]");
        $cell2 = $xpath->query("//*[contains(@class, 'sfm_cell_2')]");
        $cell2e = $xpath->query("//*[contains(@class, 'sfm_cell_e_2')]");

        $isHasGenus = (-1 < strpos($item->textContent, 'множина'));

        // main form must be first
        $wordForms = [
            [
                'word' => $cell1->item(0)->textContent,
                'number' => 'однина', 'kind' => 'називний',
                'genus' => 'жіночий рід',
                'isMainForm' => true,
            ],[
                'word' => $cell1e->item(0)->textContent,
                'number' => 'множина', 'kind' => 'називний',
                'isMainForm' => false,
            ], [
                'word' => Word::cleanWord($cell2->item(0)->textContent),
                'number' => 'однина', 'kind' => 'родовий',
                'genus' => 'жіночий рід',
                'isMainForm' => false,
            ],[
                'word' => Word::cleanWord($cell2e->item(0)->textContent),
                'number' => 'множина', 'kind' => 'родовий',
                'isMainForm' => false,
            ],[ // ***
                'word' => $cell1->item(1)->textContent,
                'number' => 'однина', 'kind' => 'давальний',
                'genus' => 'жіночий рід',
                'isMainForm' => false,
            ],[
                'word' => $cell1e->item(1)->textContent,
                'number' => 'множина', 'kind' => 'давальний',
                'isMainForm' => false,
            ], [ // ***
                'word' => $cell2->item(1)->textContent,
                'number' => 'однина', 'kind' => 'знахідний',
                'genus' => 'жіночий рід',
                'isMainForm' => false,
            ],[
                'word' => $cell2e->item(1)->textContent,
                'number' => 'множина', 'kind' => 'знахідний',
                'isMainForm' => false,
            ],[ // ***
                'word' => $cell1->item(2)->textContent,
                'number' => 'однина', 'kind' => 'орудний',
                'genus' => 'жіночий рід',
                'isMainForm' => false,
            ],[
                'word' => $cell1e->item(2)->textContent,
                'number' => 'множина', 'kind' => 'орудний',
                'isMainForm' => false,
            ], [ // ***
                'word' => Word::cleanWord($cell2->item(2)->textContent),
                'number' => 'однина', 'kind' => 'місцевий',
                'genus' => 'жіночий рід',
                'isMainForm' => false,
            ], [ // ***
                'word' => Word::cleanWord($cell2e->item(2)->textContent),
                'number' => 'множина', 'kind' => 'місцевий',
                'isMainForm' => false,
            ], [ // ***
                'word' => $cell1->item(3)->textContent,
                'number' => 'однина', 'kind' => 'кличний',
                'genus' => 'жіночий рід',
                'isMainForm' => false,
            ], [ // ***
                'word' => $cell1e->item(3)->textContent,
                'number' => 'множина', 'kind' => 'кличний',
                'isMainForm' => false,
            ]
        ];

        $isMainForm = null;

        echo '[';
        foreach ($wordForms as $wordForm) {
            echo '*';
            $word = trim(array_get($wordForm, 'word'));

            if (' ' == $word || empty($word)) {
                continue;
            }

            $number = array_get($wordForm, 'number', '-');
            $kind = array_get($wordForm, 'kind', '-');
            $genus = array_get($wordForm, 'genus', '-');
            $is_main_form = array_get($wordForm, 'isMainForm', false);

            $number = $number ? $number : '-';
            $kind = $kind ? $kind: '-';
            $genus = $genus ? $genus: '-';

            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewTotal($word, $part_of_language, 'істота', $genus, $number, '-', $kind, '-',
                '-', '-', '-', '-', '-', '-', 0, $is_main_form, '-', $dictionaryId);

            if ($is_main_form) {
                $mainFormId = $htmlItem->getId();
            }

            $htmlItem->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);
        }

        echo ']';
        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }
    echo ">\n";
}

echo 'END';



