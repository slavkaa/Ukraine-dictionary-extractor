<?php

// @acton: php word_fix_commas.php

require_once('../support/_require_once.php');

// *** //

echo "\n";
$word = new Word($dbh);
$counter = $word->countIsNeedProcessing();
$counter = intval($counter/100) + 1;
var_dump($counter);

echo "\n";

for ($i = 0; $i < $counter;  $i++) {
    $word = new Word($dbh);
    $allWords = $word->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allWords as $wordArr) {
        echo '<';
        $word_id = array_get($wordArr, 'id');

        $word = new Word($dbh);
        $word->getById($word_id);

        $wordBinary = $word->getProperty('word_binary');
        $wordBinary = str_replace(' ', '', $wordBinary);
        $wordBinary = explode(',', $wordBinary);

        $part_of_language = $word->getProperty('part_of_language');
        $creature = $word->getProperty('creature');
        $genus = $word->getProperty('genus');
        $number = $word->getProperty('number');
        $person = $word->getProperty('person');
        $kind = $word->getProperty('kind');
        $verb_kind = $word->getProperty('verb_kind');
        $dievidmina = $word->getProperty('dievidmina');
        $class = $word->getProperty('class');
        $sub_role = $word->getProperty('sub_role');
        $comparison = $word->getProperty('comparison');
        $tense = $word->getProperty('tense');
        $variation = $word->getProperty('variation');
        $mood = $word->getProperty('mood');
        $is_infinitive = (bool) $word->getProperty('is_infinitive');
        $is_main_form = (bool) $word->getProperty('is_main_form');

        $html_id = $word->getProperty('html_id');
        $main_form_code = $word->getProperty('main_form_code');

        foreach ($wordBinary as $wordBinaryItem) {
            echo '+';
            $wordX = new Word($dbh);
            $wordX->firstOrNewTotal($wordBinaryItem, $part_of_language, $creature, $genus, $number, $person, $kind, $verb_kind,
                $dievidmina, $class, $sub_role, $comparison, $tense, $variation, $mood, $is_infinitive, $is_main_form);
            if (null === $wordX->getProperty('main_form_code')) {
                $wordX->updateProperty('main_form_code', PDO::PARAM_INT, $main_form_code);
            }
            if (null === $wordX->getProperty('html_id')) {
                $wordX->updateProperty('html_id', PDO::PARAM_INT, $html_id);
            }
        }

        $word->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '>';
    }

    echo "\n";
}



