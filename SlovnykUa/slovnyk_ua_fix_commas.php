<?php

// @acton: php slovnyk_ua_fix_commas.php

require_once('../support/_require_once.php');

// *** //

echo "\n";
$resultC = new SlovnykUaResults($dbh);
$counter = $resultC->countIsNeedProcessing();
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($i = 0; $i < $counter;  $i++) {
    $result = new SlovnykUaResults($dbh);
    $allWords = $result->getAllIsNeedProcessing(100);

    echo ($i+1) . '00. ';

    foreach ($allWords as $resultArr) {
        echo '<';
        $result_id = array_get($resultArr, 'id');

        $result = new SlovnykUaResults($dbh);
        $result->getById($result_id);

        $wordBinary = $result->getProperty('word_binary');
        $wordBinary = str_replace(' ', '', $wordBinary);
        $wordBinary = explode(',', $wordBinary);

        $part_of_language = $result->getProperty('part_of_language');
        $creature = $result->getProperty('creature');
        $genus = $result->getProperty('genus');
        $number = $result->getProperty('number');
        $person = $result->getProperty('person');
        $kind = $result->getProperty('kind');
        $verb_kind = $result->getProperty('verb_kind');
        $dievidmina = $result->getProperty('dievidmina');
        $class = $result->getProperty('class');
        $sub_role = $result->getProperty('sub_role');
        $comparison = $result->getProperty('comparison');
        $tense = $result->getProperty('tense');
        $variation = $result->getProperty('variation');
        $mood = $result->getProperty('mood');
        $main_form_code = $result->getProperty('main_form_code');
        $data_id = $result->getProperty('data_id');
        $is_infinitive = (bool) $result->getProperty('is_infinitive');
        $is_main_form = (bool) $result->getProperty('is_main_form');

        $html_id = $result->getProperty('html_id');
        $main_form_code = $result->getProperty('main_form_code');

        foreach ($wordBinary as $wordBinaryItem) {
            echo '+';
            $resultX = new SlovnykUaResults($dbh);
            $resultX->firstOrNewTotal($wordBinaryItem, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                $dievidmina, $class, $sub_role, $comparison, $tense, $mood, $is_infinitive, $is_main_form, $variation, $main_form_code, $data_id);
        }

        $result->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '>';
    }

    echo "\n";
}



