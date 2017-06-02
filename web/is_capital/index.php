<?php
header('Access-Control-Allow-Origin: *', false);

require_once('../support/_require_once.php');

// --

$word_binary = $_REQUEST['word_binary'];

if ($word_binary) {
    $data = new CapitalWord($dbh);
    $data->findByWord($word_binary);
    $data->updateProperty('is_capital', PDO::PARAM_BOOL, true);
}

$word_binary_decline = $_REQUEST['word_binary_decline'];

if ($word_binary_decline) {
    $data = new CapitalWord($dbh);
    $data->findByWord($word_binary_decline);
    $data->updateProperty('is_capital', PDO::PARAM_BOOL, false);
}

// --

$stm = $dbh->query('SELECT id, word_binary from capital_word where is_capital IS NULL order by id;');

$results = $stm->fetchAll(PDO::FETCH_ASSOC);

echo '<table>';
foreach ($results as $result) {
    ?><tr><td><?= $result["id"] ?>. <?= $result["word_binary"] ?>
        <br/><br/></td><td>
        <form action = "http://dic.loc/is_capital/index.php">
            <input type="hidden" name="word_binary" value="<?= $result["word_binary"] ?>" />
            <input type="submit" value="Confirm" />
        </form></td>
    <td>
        <form action = "http://dic.loc/is_capital/index.php">
            <input type="hidden" name="word_binary_decline" value="<?= $result["word_binary"] ?>" />
            <input type="submit" value="Decline" />
        </form></td>
    </tr><?php
}
echo '</table>';