﻿<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_handle_man_name.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/wordToSource.php');
require_once('models/dictionary.php');
require_once('models/html.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

$part_of_language = 'чоловіче ім\'я';

for ($j = 0; $j < 1;  $j++) {
    echo '.';
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%' . $part_of_language . '%', 100, $j*100, 'LIKE');

    foreach ($allHtml as $htmlArray) {
        echo '+';
        /** @var Html $html */
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        // load extracted HTML=page
        $word = cleanCyrillic($html->getProperty('word'));
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
                'genus' => 'чоловічий рід',
                'isMainForm' => true,
            ],[
                'word' => $cell1e->item(0)->textContent,
                'number' => 'множина', 'kind' => 'називний',
                'isMainForm' => false,
            ], [
                'word' => $cell2->item(01)->textContent,
                'number' => 'однина', 'kind' => 'родивий',
                'genus' => 'чоловічий рід',
                'isMainForm' => false,
            ],[
                'word' => $cell2e->item(0)->textContent,
                'number' => 'однина', 'kind' => 'родивий',
                'isMainForm' => false,
            ],[ // ***
                'word' => $cell1->item(1)->textContent,
                'number' => 'однина', 'kind' => 'давльний',
                'genus' => 'чоловічий рід',
                'isMainForm' => false,
            ],[
                'word' => $cell1e->item(1)->textContent,
                'number' => 'множина', 'kind' => 'давльний',
                'isMainForm' => false,
            ], [ // ***
                'word' => $cell2->item(1)->textContent,
                'number' => 'однина', 'kind' => 'знахідний',
                'genus' => 'чоловічий рід',
                'isMainForm' => false,
            ],[
                'word' => $cell2e->item(1)->textContent,
                'number' => 'однина', 'kind' => 'знахідний',
                'isMainForm' => false,
            ],[ // ***
                'word' => $cell1->item(2)->textContent,
                'number' => 'однина', 'kind' => 'орудний',
                'genus' => 'чоловічий рід',
                'isMainForm' => false,
            ],[
                'word' => $cell1e->item(2)->textContent,
                'number' => 'множина', 'kind' => 'орудний',
                'isMainForm' => false,
            ], [ // ***
                'word' => $cell2->item(2)->textContent,
                'number' => 'однина', 'kind' => 'місцевий',
                'genus' => 'чоловічий рід',
                'isMainForm' => false,
            ], [ // ***
                'word' => $cell2e->item(2)->textContent,
                'number' => 'множина', 'kind' => 'місцевий',
                'genus' => 'чоловічий рід',
                'isMainForm' => false,
            ], [ // ***
                'word' => $cell1->item(3)->textContent,
                'number' => 'однина', 'kind' => 'кличний',
                'genus' => 'чоловічий рід',
                'isMainForm' => false,
            ], [ // ***
                'word' => $cell1e->item(3)->textContent,
                'number' => 'множина', 'kind' => 'кличний',
                'genus' => 'чоловічий рід',
                'isMainForm' => false,
            ]
        ];

        // ***
        $isMainForm = null;

        foreach ($wordForms as $wordForm) {
            $checkArr = explode(',', str_replace(' ', ',', array_get($wordForm, 'word')));
            if (in_array($word, $checkArr)) {
                $isMainForm = array_get($wordForm, 'isMainForm');
            }
        }
        // ***

        $mainFormId = null;

        $html->updateProperty('is_main_form', PDO::PARAM_BOOL, $isMainForm);

        foreach ($wordForms as $wordForm) {
            echo '*';
            $word = array_get($wordForm, 'word');
            $number = array_get($wordForm, 'number');
            $kind = array_get($wordForm, 'kind');
            $genus = array_get($wordForm, 'genus');
            $isMainForm = array_get($wordForm, 'isMainForm');

            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewByKingNumeralGenus($word, $part_of_language, $kind, $number, $genus, $dictionaryId);

            $htmlItem->updateProperty('is_main_form', PDO::PARAM_BOOL, $isMainForm);
            $htmlItem->updateProperty('url', PDO::PARAM_STR, $url);
            $htmlItem->updateProperty('url_binary', PDO::PARAM_STR, $url);

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



