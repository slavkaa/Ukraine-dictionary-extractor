<?php

// @acton: php move_results_to_word.php

require_once('../support/_require_once.php');

// *** //

$results = new SlovnykUaResults($dbh);
$counter = $results->countIsNeedProcessing();
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($i = 0; $i < $counter;  $i++) {
    $result100 = new SlovnykUaResults($dbh);
    $resultsPack = $result100->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($resultsPack as $resultsArr) {
        $id = array_get($resultsArr, 'id');
        $wordText = array_get($resultsArr, 'word_binary');

        if ('' == $wordText) {
            continue;
        }

        $result = new SlovnykUaResults($dbh);
        $result->getById($id);

        if ($result->isNew()) {
            echo 'Broken HTML node, ID ' . $id . '. ';
        }

        // part_of_language
        $value = $result->getProperty('part_of_language');
        $value = str_replace("'", '`', $value);

        if ('' == $value) {
            echo 'E';
            $result->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }

        if (false == in_array($value, ['займенник','іменник','прикметник','дієслово','дієприкметник','дієприслівник','прислівник','частка','вигук','сполучник','прийменник','числівник','присудкове слово','чоловіче ім`я','жіноче ім`я','вставне слово', null])) {
            if (-1 < strpos($value, ',')) {
                echo 'C';
                $result->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
                continue;
            } else {
                echo 'Wrong part_of_language ';
                var_dump($value);
                echo '.HTML node, ID ' . $id . '. ';
                die;
            }
        }
        $part_of_language = $value;

        echo '<';

        // creature
        $value = $result->getProperty('creature');
        $value = trim($value);
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['істота','неістота','істота і неістота', '-'])) {
            echo 'Wrong creature ' . $value;
            echo '.HTML node, ID ' . $id . '. ';
            die;
        }
        $creature = $value;

        // genus
        $value = $result->getProperty('genus');
        $value = str_replace(' рід', '', $value);
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['чоловічий','жіночий','середній','чоловічий і жіночий', '-'])) {
            echo 'Wrong genus ' . $value;
            echo '.HTML node, ID ' . $id . '. ';
            die;
        }
        $genus = $value;

        // number
        $value = $result->getProperty('number');
        $value = str_replace('тільки ', '', $value);
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['однина','множина', '-'])) {
            echo 'Wrong number';
            die;
        }
        $number = $value;

        // person
        $value = $result->getProperty('person');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['1 особа','2 особа','3 особа', '-'])) {
            echo 'Wrong person';
            die;
        }
        $person = $value;

        // kind
        $value = $result->getProperty('kind');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['називний','родовий','давальний','знахідний','орудний','місцевий','кличний', '-'])) {
            echo 'Wrong kind ' . $value;
            echo '.HTML node, ID ' . $id . '. ';
            die;
        }
        $kind = $value;

        // verb_kind
        $value = $result->getProperty('verb_kind');
        $value = str_replace(' вид', '', $value);
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['доконаний','недоконаний', '-'])) {
            echo 'Wrong verb_kind';
            echo '.HTML node, ID ' . $id . '. ';
            die;
        }
        $verb_kind = $value;

        // dievidmina
        $value = $result->getProperty('dievidmina');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['1 дієвідміна','2 дієвідміна', '-'])) {
            echo 'Wrong dievidmina';
            die;
        }
        $dievidmina = $value;

        // class
        $value = $result->getProperty('class');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['особовий','зворотній','взаємний','присвійний','вказівний','означальний','питальний','відносний','неозначений','заперечний', '-'])) {
            echo 'Wrong class';
            die;
        }
        $class = $value;

        // sub_role
        $value = $result->getProperty('sub_role');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['іменник','прикметник','числівник','прислівник', '-'])) {
            echo 'Wrong sub_role';
            die;
        }
        $sub_role = $value;

        // comparison
        $value = $result->getProperty('comparison');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['перший','вищий простий','вищий складений','найвищий простий','найвищий складений', '-'])) {
            echo 'Wrong comparison';
            die;
        }
        $comparison = $value;

        // tense
        $value = $result->getProperty('tense');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['майбутній','теперішній','минулий','наказовий спосіб','-'])) {
            echo 'Wrong tense';
            echo '.HTML node, ID ' . $id . '. ';
            die;
        }
        $tense = $value;

        // variation
        $value = $result->getProperty('variation');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['1 відміна','2 відміна','3 відміна','4 відміна','невідмінюване','-'])) {
            echo 'Wrong variation';
            echo '.HTML node, ID ' . $id . '. ';
            die;
        }
        $variation = $value;

        // is_main_form
        $is_main_form = (bool) $result->getProperty('is_main_form', false);

        // is_infinitive
        $is_infinitive = (bool) $result->getProperty('is_infinitive', false);

        $main_form_code = $result->getProperty('main_form_id');

        // --------------------------------------

        $word = new Word($dbh);
        $word->firstOrNewTotal($wordText, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
            $dievidmina, $class, $sub_role, $comparison, $tense, $variation, '-', $is_infinitive, $is_main_form, $main_form_code);

        $word->updateProperty('html_id', PDO::PARAM_INT, $result->getId());

//        $word->updateProperty('main_form_code', PDO::PARAM_STR, $main_form_code);
//        $word->updateUniqueCode($wordText, $main_form_code, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
//            $dievidmina, $class, $sub_role, $comparison, $tense, $variation, '-', $is_infinitive, $is_main_form);

        $result->updateProperty('word_id', PDO::PARAM_INT, $word->getId());
        $result->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);

        echo '>';
    }

    echo "\n";
}



