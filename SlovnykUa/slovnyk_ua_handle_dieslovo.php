﻿<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_handle_dieslovo.php

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

$part_of_language = 'дієслово';

echo "\n";

for ($j = 0; $j < 125;  $j++) { // 125
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%' . $part_of_language . '%', 100, $j*100, 'LIKE');

    foreach ($allHtml as $htmlArray) {
        echo '<';
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        // load extracted HTML=page
        $word = cleanCyrillic($html->getProperty('word'));
        $text = cleanCyrillic($html->getProperty('html_cut'));
        $text = str_replace(
            ['sfm_cell_1s', 'sfm_cell_2s', 'sfm_cell_1_x2', 'sfm_cell_1e_x2', 'sfm_cell_1e', 'sfm_cell_2_x2', 'sfm_cell_2e_x2', 'sfm_cell_2e'],
            ['sfm_cell_v',  'sfm_cell_v',  'sfm_cell_1',    'sfm_cell_e_1',   'sfm_cell_e_1',   'sfm_cell_2',    'sfm_cell_2e', 'sfm_cell_e_2'],
            $text);

        // filtrate $part_of_language {
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

                    break;
                }
            }

            if (!$isFound) {
                continue;
            }
        // filtrate $part_of_language }

        // extract table
        $xpath = new DOMXpath($doc);
        /** @var DOMNodeList $partOfLanguageData */
        $definition = $xpath->query("//*[contains(@class, 'sfm_cell_hx')]");
        $definition = $definition->item(0)->textContent;
        $definition = explode(',', $definition);

        $infinitive = trim(str_replace(['дієслово', '-', ' '], '', array_get($definition, 0)));
        $verbKind = trim(array_get($definition, 1, '-'));
        $dievidmina = trim(array_get($definition, 2, '-'));

        $dievidmina = $dievidmina ? $dievidmina : '-';
        $verbKind = $verbKind ? $verbKind : '-';

        $cell2 = $xpath->query("//*[contains(@class, 'sfm_cell_2')]");
        $cell2e = $xpath->query("//*[contains(@class, 'sfm_cell_e_2')]");

        $infinitiveArr = [
            'word' => $infinitive,
            'verb_kind' => str_replace(' вид', '', $verbKind) ,
            'dievidmina' => $dievidmina,
        ];

        // main form must be first
        $wordForms = [
            [
                'word' => $cell2->item(0)->textContent,
                'tense' => 'теперішній час',
                'number' => 'однина',
                'person' => '1 особа',
            ],[
                'word' => $cell2->item(1)->textContent,
                'tense' => 'теперішній час',
                'number' => 'однина',
                'person' => '2 особа',
            ],[
                'word' => $cell2->item(2)->textContent,
                'tense' => 'теперішній час',
                'number' => 'однина',
                'person' => '3 особа',
            ],[
                'word' => $cell2e->item(0)->textContent,
                'tense' => 'теперішній час',
                'number' => 'множина',
                'person' => '1 особа',
            ],[
                'word' => $cell2e->item(1)->textContent,
                'tense' => 'теперішній час',
                'number' => 'множина',
                'person' => '2 особа',
            ],[
                'word' => $cell2e->item(2)->textContent,
                'tense' => 'теперішній час',
                'number' => 'множина',
                'person' => '3 особа',
            ],[ // ***
                'word' => $cell2->item(3)->textContent,
                'tense' => 'майбутній час',
                'number' => 'однина',
                'person' => '1 особа',
            ],[
                'word' => $cell2->item(4)->textContent,
                'tense' => 'майбутній час',
                'number' => 'однина',
                'person' => '2 особа',
            ],[
                'word' => $cell2->item(5)->textContent,
                'tense' => 'майбутній час',
                'number' => 'однина',
                'person' => '3 особа',
            ],[
                'word' => $cell2e->item(3)->textContent,
                'tense' => 'майбутній час',
                'number' => 'множина',
                'person' => '1 особа',
            ],[
                'word' => $cell2e->item(4)->textContent,
                'tense' => 'майбутній час',
                'number' => 'множина',
                'person' => '2 особа',
            ],[
                'word' => $cell2e->item(5)->textContent,
                'tense' => 'майбутній час',
                'number' => 'множина',
                'person' => '3 особа',
            ],[ // ***
                'word' => $cell2->item(6)->textContent,
                'tense' => 'минулий час',
                'number' => 'однина',
                'genus' => 'чоловічий рід',
            ],[
                'word' => $cell2->item(7)->textContent,
                'tense' => 'минулий час',
                'number' => 'однина',
                'genus' => 'жіночий рід',
            ],[
                'word' => $cell2->item(8)->textContent,
                'tense' => 'минулий час',
                'number' => 'однина',
                'genus' => 'середній рід',
            ],[
                'word' => $cell2e->item(6)->textContent,
                'tense' => 'минулий час',
                'number' => 'множина',
                'person' => '1 особа',
            ],[
                'word' => $cell2e->item(6)->textContent,
                'tense' => 'минулий час',
                'number' => 'множина',
                'person' => '2 особа',
            ],[
                'word' => $cell2e->item(6)->textContent,
                'tense' => 'минулий час',
                'number' => 'множина',
                'person' => '3 особа',
            ],[ // ***
                'word' => trim($cell2->item(9)->textContent),
                'tense' => 'наказовий спосіб',
                'number' => 'однина',
                'person' => '1 особа',
            ],[
                'word' => $cell2->item(10)->textContent,
                'tense' => 'наказовий спосіб',
                'number' => 'однина',
                'person' => '2 особа',
            ],[
                'word' => $cell2e->item(7)->textContent,
                'tense' => 'наказовий спосіб',
                'number' => 'множина',
                'person' => '1 особа',
            ],[
                'word' => $cell2e->item(8)->textContent,
                'tense' => 'наказовий спосіб',
                'number' => 'множина',
                'person' => '2 особа',
            ]
        ];

        $diepruslivnyk = [
            [
                'word' => trim($cell2e->item(9)->textContent),
                'tense' => 'теперішній час',
            ],[
                'word' => trim($cell2e->item(10)->textContent),
                'tense' => 'минулий час',
            ]
        ];

        $isInfinitive = ($infinitive === $word);

        // define infinitive {
        $mainFormId = null;
        if ( " " != $infinitive && !empty($infinitive)) {
            echo 'i';
            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewTotal($infinitive, 'дієслово', '-', '-', '-', '-', '-', $verbKind,
                $dievidmina, '-', '-', '-', '-', '-', 1, 1, '-', $dictionaryId);
            $mainFormId = $htmlItem->getId();
        }
        // define infinitive }

        foreach ($wordForms as $wordForm) {
            echo 'd';
            $word = trim(array_get($wordForm, 'word'));
            $tense = str_replace(' час', '', array_get($wordForm, 'tense', '-'));
            $number = array_get($wordForm, 'number', '-');
            $genus = array_get($wordForm, 'genus', '-');
            $person = array_get($wordForm, 'person', '-');

            $genus = $genus ? $genus : '-';
            $tense = $tense ? $tense : '-';
            $number = $number ? $number : '-';
            $person = $person ? $person : '-';

            if ( " " == $word || empty($word)) {
                continue;
            }
            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewTotal($word, 'дієслово', '-', $genus, $number, $person, '-', $verbKind,
                $dievidmina, '-', '-', '-', $tense, '-', 0, 0, '-', $dictionaryId);
            $htmlItem->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);
        }

        foreach ($diepruslivnyk as $wordForm) {
            echo 'p';
            $word = trim(array_get($wordForm, 'word'));
            $tense = array_get($wordForm, 'tense', '-');

            if (' ' == $word || empty($word)) {
                continue;
            }

            $htmlItem->firstOrNewTotal(trim($word), 'дієприслівник', '-', '-', '-', '-', '-', '-',
                '-', '-', '-', '-', $tense, '-', 0, 0, '-', $dictionaryId);
            $htmlItem->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);
        }

        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '>';
    }
}

echo 'END';



