<?php

// @acton: php slovnyk_ua_results_fix_data_id.php

require_once('../support/_require_once.php');

echo "\n";

for ($i = 1; $i < 345310;  $i++) {
    echo $i . ' :: ';

    $data = new SlovnykUaData($dbh);
    $data->getById($i);

    if (null === $data->getId()) {
        echo '-';
    } else {
        $sql = 'UPDATE `slovnyk_ua_results` SET data_id = :id where word_binary = :word_binary limit 1;';
        $stm = $dbh->prepare($sql);
        $stm->bindParam(':id', $i, PDO::PARAM_INT);
        $stm->bindParam(':word_binary', $data->getWordBinary(), PDO::PARAM_STR);
        $stm->execute();

        echo '+';
    }
}



