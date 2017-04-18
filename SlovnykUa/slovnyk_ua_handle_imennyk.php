<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_handle_imennyk.php

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

for ($j = 0; $j < 140;  $j++) {
    echo '.';
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%іменник%', 100, $j*100, 'LIKE');

    foreach ($allHtml as $htmlArray) {
        echo '+';
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        if (false == $html->getProperty('is_need_processing', false)) {
            echo 's';
            continue;
        }
        echo 'p';

        // load extracted HTML=page
        $word = cleanCyrillic($html->getProperty('word'));
        $text = cleanCyrillic($html->getProperty('html_cut'));

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
                if (-1 < strpos($item->textContent, 'іменник')) {
                    $doc = new DOMDocument();
                    @$doc->loadHTML(mb_convert_encoding($item->ownerDocument->saveHTML($item), 'HTML-ENTITIES', 'UTF-8'));
                    $isFound = true;

                    break;
                }
            }

            if (!$isFound) {
                continue;
            }
        // filtrate noun }

        // extract table
        $xpath = new DOMXpath($doc);
        /** @var DOMNodeList $partOfLanguageData */
        $definition = $xpath->query("//*[contains(@class, 'sfm_cell_hx')]");
        $definition = $definition->item(0)->textContent;
        $definition = explode(',', $definition);

        $part_of_language = 'іменник';
        $creature = trim(array_get($definition, 2)); // istota
        $genus = trim(array_get($definition, 1)); // rid
        $variation = trim(array_get($definition, 3));

        $isMainForm = false;

        $cell1 = $xpath->query("//*[contains(@class, 'sfm_cell_1')]");
        $cell2 = $xpath->query("//*[contains(@class, 'sfm_cell_2')]");

        // main form must be first
        $wordForms = [
            [
                'word' => $cell1->item(1)->textContent,
                'number' => 'однина',
                'kind' => 'називний',
                'isMainForm' => true,
            ],[
                'word' => $cell1->item(2)->textContent,
                'number' => 'множина',
                'kind' => 'називний',
                'isMainForm' => false,
            ],[
                'word' => $cell2->item(1)->textContent,
                'number' => 'однина',
                'kind' => 'родовий',
                'isMainForm' => false,
            ],[
                'word' => $cell2->item(2)->textContent,
                'number' => 'множина',
                'kind' => 'родовий',
                'isMainForm' => false,
            ],[
                'word' => $cell1->item(4)->textContent,
                'number' => 'однина',
                'kind' => 'давальний',
                'isMainForm' => false,
            ],[
                'word' => $cell1->item(5)->textContent,
                'number' => 'множина',
                'kind' => 'давальний',
                'isMainForm' => false,
            ],[
                'word' => $cell2->item(4)->textContent,
                'number' => 'однина',
                'kind' => 'знахідний',
                'isMainForm' => false,
            ],[
                'word' => $cell2->item(5)->textContent,
                'number' => 'множина',
                'kind' => 'знахідний',
                'isMainForm' => false,
            ],[
                'word' => $cell1->item(7)->textContent,
                'number' => 'однина',
                'kind' => 'орудний',
                'isMainForm' => false,
            ],[
                'word' => $cell1->item(8)->textContent,
                'number' => 'множина',
                'kind' => 'орудний',
                'isMainForm' => false,
            ],[
                'word' => $cell2->item(7)->textContent,
                'number' => 'однина',
                'kind' => 'місцевий',
                'isMainForm' => false,
            ],[
                'word' => $cell2->item(8)->textContent,
                'number' => 'множина',
                'kind' => 'місцевий',
                'isMainForm' => false,
            ],[
                'word' => $cell1->item(10)->textContent,
                'number' => 'однина',
                'kind' => 'кличний',
                'isMainForm' => false,
            ],[
                'word' => $cell1->item(11)->textContent,
                'number' => 'множина',
                'kind' => 'кличний',
                'isMainForm' => false,
            ]
        ];

        // ***
        $number = null;
        $kind = null;

        $singN = explode(',', str_replace(' ', ',', cleanCyrillic($cell1->item(1)->textContent)));
        $pluralN = explode(',', str_replace(' ', ',', cleanCyrillic($cell1->item(2)->textContent)));
        $singR = explode(',', str_replace(' ', ',', cleanCyrillic($cell2->item(1)->textContent)));
        $pluralR = explode(',', str_replace(' ', ',', cleanCyrillic($cell2->item(2)->textContent)));
        $singD = explode(',', str_replace(' ', ',', cleanCyrillic($cell1->item(4)->textContent)));
        $pluralD = explode(',', str_replace(' ', ',', cleanCyrillic($cell1->item(5)->textContent)));
        $singZ = explode(',', str_replace(' ', ',', cleanCyrillic($cell2->item(4)->textContent)));
        $pluralZ = explode(',', str_replace(' ', ',', cleanCyrillic($cell2->item(5)->textContent)));
        $singO = explode(',', str_replace(' ', ',', cleanCyrillic($cell1->item(7)->textContent)));
        $pluralO = explode(',', str_replace(' ', ',', cleanCyrillic($cell1->item(8)->textContent)));
        $singM = explode(',', str_replace(' ', ',', cleanCyrillic($cell2->item(7)->textContent)));
        $pluralM = explode(',', str_replace(' ', ',', cleanCyrillic($cell2->item(8)->textContent)));
        $singK = explode(',', str_replace(' ', ',', cleanCyrillic($cell1->item(10)->textContent)));
        $pluralK = explode(',', str_replace(' ', ',', cleanCyrillic($cell1->item(11)->textContent)));

        if (in_array($word, $singN)) {
            $number = 'однина';
            $kind = 'називний';
            $isMainForm = true;
        } elseif (in_array($word, $pluralN)) {
            $number = 'множина';
            $kind = 'називний';
        } elseif (in_array($word, $singR)) {
            $number = 'однина';
            $kind = 'родовий';
        } elseif (in_array($word, $pluralR)) {
            $number = 'множина';
            $kind = 'родовий';
        } elseif (in_array($word, $singD)) {
            $number = 'однина';
            $kind = 'давальний';
        } elseif (in_array($word, $pluralD)) {
            $number = 'множина';
            $kind = 'давальний';
        } elseif (in_array($word, $singZ)) {
            $number = 'однина';
            $kind = 'знахідний';
        } elseif (in_array($word, $pluralZ)) {
            $number = 'множина';
            $kind = 'знахідний';
        }if (in_array($word, $singO)) {
            $number = 'однина';
            $kind = 'орудний';
        } elseif (in_array($word, $pluralO)) {
            $number = 'множина';
            $kind = 'орудний';
        } elseif (in_array($word, $singM)) {
            $number = 'однина';
            $kind = 'місцевий';
        } elseif (in_array($word, $pluralM)) {
            $number = 'множина';
            $kind = 'місцевий';
        } elseif (in_array($word, $singK)) {
            $number = 'однина';
            $kind = 'кличний';
        } elseif (in_array($word, $pluralK)) {
            $number = 'множина';
            $kind = 'кличний';
        }

        // ***
        
        $mainFormId = null;

        $html->updateProperty('is_main_form', PDO::PARAM_BOOL, $isMainForm);

        foreach ($wordForms as $wordForm) {
            echo '*';
            $word = trim(array_get($wordForm, 'word'));

            if ('' == $word || empty($word)) {
                continue;
            }

            $number = array_get($wordForm, 'number');
            $kind = array_get($wordForm, 'kind');
            $isMainForm = array_get($wordForm, 'isMainForm');

            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewImennyk($word, $kind, $number, $dictionaryId);

            $htmlItem->updateProperty('creature', PDO::PARAM_BOOL, $creature);
            $htmlItem->updateProperty('genus', PDO::PARAM_STR, $genus);
            $htmlItem->updateProperty('variation', PDO::PARAM_STR, $variation);
            $htmlItem->updateProperty('is_main_form', PDO::PARAM_BOOL, $isMainForm);

            if ($isMainForm) {
                $mainFormId = $htmlItem->getId();

                if ($html->getId() !== $mainFormId) {
                    $html->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);
                }
            } else {
                $htmlItem->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);
            }

            echo 'ID(' . $htmlItem->getId() . ')';
        }
    }

}

echo 'END';



