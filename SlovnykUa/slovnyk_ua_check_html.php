<?php

// @acton: php slovnyk_ua_check_html.php > 1.html

require_once('../support/_require_once.php');

// *** //

$html = new SlovnykUaHtml($dbh);
//$html->getMaxFilledHtml();
$html->getByDataId(11);

$url = $html->getProperty('url');
$text = $html->getProperty('html_cut');

echo urldecode($url);
echo iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);



