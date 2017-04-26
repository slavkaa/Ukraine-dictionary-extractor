<?php

// php check_html.php > 1.html

require_once('../support/_require_once.php');

// *** //

$html = new SumInUaHtml($dbh);
//$html->getMaxFilledHtml();
$html->getByDataId(4939);

$text = $html->getProperty('html_cut');

echo iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);



