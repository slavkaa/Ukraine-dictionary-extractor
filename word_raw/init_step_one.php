<?php

// @acton: php init_step_one.php

require_once('../support/_require_once.php');

// Authors
//require_once('config/honchar.php');
// require_once('config/franko.php');
// require_once('config/nechuy.php');
 require_once('config/sheva.php');

foreach ($titles as $title) {
    echo $title . "\n";
    echo '.';
    $filename = sprintf('../texts/%s/%s', $author, $title);
    $filename = iconv(mb_detect_encoding($filename, mb_detect_order(), true), "cp1251", $filename);

    $text = file_get_contents($filename);

    $text = iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text); // back to cyryllic
    $text = str_replace($pronunciationSings, ' ', $text); // remove pronunciation sings
    $text = str_replace($pronunciationSings, ' ', $text); // remove pronunciation sings
    // двічи, щоб гарантовано очистити комбіновані пунктуаційні символи на шкалт [-"(доречі...]
    $text = str_replace($numbers, ' ', $text); // remove pronunciation sings
    $text = str_replace($foreignLetters, ' ', $text); // remove pronunciation sings
    $text = str_replace($foreignLetters, ' ', $text); // remove pronunciation sings
    $text = str_replace(['  ','  ','  ','  ','  ','  ','  ',' -','- ',], ' ', $text); // remove pronunciation sings

    // Write prepared texts
    $filenameWrite = sprintf('../texts/%s/processed/%s', $author, $title);
    $filenameWrite = iconv(mb_detect_encoding($filenameWrite, mb_detect_order(), true), "cp1251", $filenameWrite);
    if (!file_exists($filenameWrite)) {
        file_put_contents($filenameWrite, $text, FILE_TEXT);
    }

    $textWords = array_unique(explode(' ', $text)); // remove word dublicates

    $source = new Source($dbh);
    $source->firstOrNew($author, $title);

    foreach ($textWords as $textWord) {
        $textWord = trim($textWord);
        $textWord = str_replace(["'", '"','’'], ['`','`','`'], $textWord);

        if ("" == $textWord || empty($textWord)) {
            echo ".\n";
            continue;
        }

        // detect non ukrainian symbols in $textWord
        if (!array_in_string($ukraineAbc, $textWord)) {
            var_dump($textWord);
            die;
        }

        echo '+';
        $wordRaw = new WordRaw($dbh);
        $wordRaw->firstOrNew($textWord);

        $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, true);

        $wordRawToSource = new WordRawToSource($dbh);
        $wordRawToSource->firstOrNew($source->getId(), $wordRaw->getId());
    }

    echo "\n";
}



