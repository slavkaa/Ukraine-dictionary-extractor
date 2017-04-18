<?php

// @link: http://phpfaq.ru/pdo
// @acton: php migrate_html_back_to_word.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/dictionary.php');
require_once('models/html.php');

// *** //

for ($i = 1; $i < 4824;  $i++) {
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allHtml as $htmlArr) {
        echo '<';

        $id = array_get($htmlArr, 'id');
        $wordText = array_get($htmlArr, 'word_binary');
        $html = new Html($dbh);
        $html->getById($id);

        if ($html->isNew()) {
            echo 'Broken HTML node, ID ' . $id . '. ';
        }

        // part_of_language
        $value = $html->getProperty('part_of_language');
        $value = str_replace("'", '`', $value);
        if (false == in_array($value, ['займенник','іменник','прикметник','дієслово','дієприкметник','дієприслівник','прислівник','частка','вигук','сполучник','прийменник','числівник','присудкове слово','чоловіче ім`я','жіноче ім`я','вставне слово', null])) {
            if (null === $part_of_language) {
                continue;
            }

            if (-1 < strpos($value, ',')) {
                // ignore
            } else {
                echo 'Wrong part_of_language ';
                var_dump($value);
                echo '.HTML node, ID ' . $id . '. ';
                die;
            }
        }
        $part_of_language = $value;

        // creature
        $value = $html->getProperty('creature');
        $value = trim($value);
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['істота','неістота','істота і неістота', '-'])) {
            echo 'Wrong creature ' . $value;
            echo '.HTML node, ID ' . $id . '. ';
            die;
        }
        $creature = $value;

        // genus
        $value = $html->getProperty('genus');
        $value = str_replace(' рід', '', $value);
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['чоловічий','жіночий','середній','чоловічий і жіночий', '-'])) {
            echo 'Wrong genus ' . $value;
            echo '.HTML node, ID ' . $id . '. ';
            die;
        }
        $genus = $value;

        // number
        $value = $html->getProperty('number');
        $value = str_replace('тільки ', '', $value);
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['однина','множина', '-'])) {
            echo 'Wrong number';
            die;
        }
        $number = $value;

        // person
        $value = $html->getProperty('person');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['1 особа','2 особа','3 особа', '-'])) {
            echo 'Wrong person';
            die;
        }
        $person = $value;

        // kind
        $value = $html->getProperty('kind');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['називний','родовий','давальний','знахідний','орудний','місцевий','кличний', '-'])) {
            echo 'Wrong kind ' . $value;
            die;
        }
        $kind = $value;

        // verb_kind
        $value = $html->getProperty('verb_kind');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['доконаний','недоконаний', '-'])) {
            echo 'Wrong verb_kind';
            die;
        }
        $verb_kind = $value;

        // dievidmina
        $value = $html->getProperty('dievidmina');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['1 дієвідміна','2 дієвідміна', '-'])) {
            echo 'Wrong dievidmina';
            die;
        }
        $dievidmina = $value;

        // class
        $value = $html->getProperty('class');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['особовий','зворотній','взаємний','присвійний','вказівний','означальний','питальний','відносний','неозначений','заперечний', '-'])) {
            echo 'Wrong class';
            die;
        }
        $class = $value;

        // sub_role
        $value = $html->getProperty('sub_role');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['іменник','прикметник','числівник','прислівник', '-'])) {
            echo 'Wrong sub_role';
            die;
        }
        $sub_role = $value;

        // comparison
        $value = $html->getProperty('comparison');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['перший','вищий простий','вищий складений','найвищий простий','найвищий складений', '-'])) {
            echo 'Wrong comparison';
            die;
        }
        $comparison = $value;

        // tense
        $value = $html->getProperty('tense');
        $value = (null == $value) ? '-' : $value;
        if (false == in_array($value, ['майбутній час','теперешній час','минулий час','наказовий спосіб', '-'])) {
            echo 'Wrong tense';
            die;
        }
        $tense = $value;

        // is_main_form
        $is_main_form = $html->getProperty('is_main_form', false);

        // is_infinitive
        $is_infinitive = $html->getProperty('is_infinitive', false);

        // --------------------------------------

        $word = new Word($dbh);
        $word->firstOrNewTotal($wordText, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
            $dievidmina, $class, $sub_role, $comparison, $tense, '-', $is_infinitive, $is_main_form);

        if ($word->isNew()) {
            $html->updateProperty('word_id', PDO::PARAM_INT, $word->getId());
        }

        // --------------------------------------

        // html_id

        $word->updateProperty('html_id', PDO::PARAM_INT, $html->getId());

        // is_need_processing

        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '>';
        die;
    }

    echo "\n";
}



