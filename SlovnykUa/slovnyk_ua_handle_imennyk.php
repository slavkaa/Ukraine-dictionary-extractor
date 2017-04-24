<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_handle_imennyk.php

require_once('../support/_require_once.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

$part_of_language = 'іменник';

$htmlObj = new Html($dbh);
$counter = $htmlObj->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;
var_dump($counter);

echo "\n";

for ($j = 0; $j < $counter;  $j++) {
    echo ($j + 1) . "00: \n";
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%'.$part_of_language.'%', 100, 0, 'LIKE');

    foreach ($allHtml as $htmlArray) {
        echo '<';
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        // load extracted HTML=page
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
        $definition = explode(',', $definition);

        $creature = trim(array_get($definition, 2, '-'));

        $genus = trim(array_get($definition, 1, '-')); // rid
        $genus = str_replace(' рід', '', $genus);

        $variation = trim(array_get($definition, 3, '-'));

        if ('тільки множина' == trim($variation) || 'тільки однина' == trim($variation)) {
            $creature = trim(array_get($definition, 2, '-'));
            $genus = '-';
            $variation = '-';
        }

        if ('істота' == trim($genus) || 'неістота' == trim($genus)) {
            $creature = trim(array_get($definition, 1, '-'));
            $genus = '-';
            $variation = '-';
        }

        if ('тільки множина' == trim($genus) || 'тільки множина(мн.)' == trim($genus)) {
            $creature = '-';
            $genus = '-';
            $variation = '-';
        }

        $genus = str_replace(' рід', '', $genus);

        $creature = $creature ? $creature : '-';
        $genus = $genus ? $genus : '-';
        $variation = $variation ? $variation : '-';

        $isMainForm = false;

        // standardisation {
        if ('тільки множина' === $creature) {
            $creature = '-';
        }

        if (-1 < strpos($variation, 'ІІІ відміна')) {
            $variation = '3 відміна';
        } elseif (-1 < strpos($variation, 'ІІ відміна')) {
            $variation = '2 відміна';
        } elseif (-1 < strpos($variation, 'І відміна')) {
            $variation = '1 відміна';
        } elseif (-1 < strpos($variation, 'ІV відміна')) {
            $variation = '4 відміна';
        } elseif (-1 < strpos($variation, 'невідмінюване')) {
            $variation = 'невідмінюване';
        } elseif ('-' === $variation) {
            // OK
        } else {
            var_dump($variation);
            $variation = null;
        }
        // standardisation }

        $cell1 = $xpath->query("//*[contains(@class, 'sfm_cell_1')]");
        $cell2 = $xpath->query("//*[contains(@class, 'sfm_cell_2')]");

        $cell1e = $xpath->query("//*[contains(@class, 'sfm_cell_1e')]");
        $cell2e = $xpath->query("//*[contains(@class, 'sfm_cell_2e')]");

        if (12 === $cell1->length && 9 === $cell2->length && 4 === $cell1e->length && 3 === $cell2e->length) {
            // OK
        } else {
            var_dump($cell1->length, $cell2->length, $cell1e->length, $cell2e->length);
            die('Wrong amount of cells. Html.id ' . array_get($htmlArray, 'id'));
        }

        if ('' === $cell1->item(1)->textContent) {
            $wordForms = [
                [
                    'word' => $cell1e->item(0)->textContent,
                    'number' => 'множина',
                    'kind' => 'називний',
                    'isMainForm' => true,
                ],[
                    'word' => Word::cleanWord($cell2e->item(0)->textContent),
                    'number' => 'множина',
                    'kind' => 'родовий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell1e->item(1)->textContent,
                    'number' => 'множина',
                    'kind' => 'давальний',
                    'isMainForm' => false,
                ],[
                    'word' => $cell2e->item(1)->textContent,
                    'number' => 'множина',
                    'kind' => 'знахідний',
                    'isMainForm' => false,
                ],[
                    'word' => $cell1e->item(2)->textContent,
                    'number' => 'множина',
                    'kind' => 'орудний',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell2e->item(2)->textContent),
                    'number' => 'множина',
                    'kind' => 'місцевий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell1e->item(2)->textContent,
                    'number' => 'множина',
                    'kind' => 'кличний',
                    'isMainForm' => false,
                ]
            ];
        } else {
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
                    'word' => Word::cleanWord($cell2->item(1)->textContent),
                    'number' => 'однина',
                    'kind' => 'родовий',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell2->item(2)->textContent),
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
                    'kind' => 'орудний', 'isMainForm' => false,
                ],[
                    'word' => $cell1->item(8)->textContent,
                    'number' => 'множина',
                    'kind' => 'орудний', 'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell2->item(7)->textContent),
                    'number' => 'однина',
                    'kind' => 'місцевий',  'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell2->item(8)->textContent),
                    'number' => 'множина',
                    'kind' => 'місцевий',  'isMainForm' => false,
                ],[
                    'word' => $cell1->item(10)->textContent,
                    'number' => 'однина',
                    'kind' => 'кличний', 'isMainForm' => false,
                ],[
                    'word' => $cell1->item(11)->textContent,
                    'number' => 'множина',
                    'kind' => 'кличний', 'isMainForm' => false,
                ]
            ];
        }
        
        $mainFormId = null;

        foreach ($wordForms as $wordForm) {
            echo '[';
            $word = trim(array_get($wordForm, 'word'));

            if (' ' == $word || empty($word)) {
                continue;
            }

            $number = array_get($wordForm, 'number', '-');
            $kind = array_get($wordForm, 'kind', '-');
            $is_main_form = (bool) array_get($wordForm, 'isMainForm', false);

            $number = $number ? $number : '-';
            $kind = $kind ? $kind: '-';

            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewTotal($word, $part_of_language, $creature, $genus, $number, '-', $kind, '-',
                '-', '-', '-', '-', '-', '-', 0, $is_main_form, $variation, $dictionaryId);

            if ($is_main_form) {
                $mainFormId = $htmlItem->getId();
            }

            $htmlItem->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);

            echo ']';
        }

        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '>';
    }
}

$htmlObj->backHtmlRowsToProcessing();

echo 'END';



