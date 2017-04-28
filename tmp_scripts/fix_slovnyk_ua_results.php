<?php

// @acton: php fix_slovnyk_ua_results.php

require_once('../support/_require_once.php');

echo "\n";

for ($i = 1; $i < 377553;  $i++) {
//    echo $i . ' :: ';

    $data = new SlovnykUaResults($dbh);
    $data->getById($i);

    if (null === $data->getProperty('word_binary')) {
        echo '-';
    } else {
        $sql = 'INSERT INTO slovnyk_ua_results_copy (data_id, word_id, word, word_binary, main_form_id, is_wrong_detection, url, url_binary, is_main_form, is_proper_name, is_foreign, is_need_processing, part_of_language, creature, genus, number, person, kind, verb_kind, dievidmina, class, sub_role, comparison, tense, variation, mood, is_infinitive, is_modal)
                         SELECT data_id, word_id, word, word_binary, main_form_id, is_wrong_detection, url, url_binary, is_main_form, is_proper_name, is_foreign, is_need_processing, part_of_language, creature, genus, number, person, kind, verb_kind, dievidmina, class, sub_role, comparison, tense, variation, mood, is_infinitive, is_modal FROM slovnyk_ua_results where id = :id;';
        $stm = $dbh->prepare($sql);
        $stm->bindParam(':id', $i, PDO::PARAM_INT);
        $stm->execute();

//            var_dump($dbh->errorInfo());
//            var_dump($stm->errorInfo());

        echo '+';
    }
}



