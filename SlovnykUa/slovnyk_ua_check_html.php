<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_check_html.php > 1.html

require_once('../support/config.php');
require_once('../support/functions.php');
require_once('../support/libs.php');
require_once('../models/word.php');
require_once('../models/wordToIgnore.php');
require_once('../models/source.php');
require_once('../models/dictionary.php');
require_once('../models/html.php');

// *** //

$html = new Html($dbh);
//$html->getMaxFilledHtml();
$html->getById(1339977);

$url = $html->getProperty('url');
$text = $html->getProperty('html');

echo urldecode($url);
echo iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);



