<?php
require_once(__DIR__.'/config.php');

require_once(__DIR__.'/functions.php');
require_once(__DIR__.'/libs.php');

// Models:

require_once(__DIR__.'/../models/dictionary.php');

require_once(__DIR__.'/../models/html.php');
require_once(__DIR__.'/../models/HtmlData.php');

require_once(__DIR__.'/../models/SlovnykUaData.php');
require_once(__DIR__.'/../models/SlovnykUaHtml.php');
require_once(__DIR__.'/../models/SlovnykUaResults.php');
require_once(__DIR__.'/../models/word.php');

require_once(__DIR__ . '/../models/Lcorp/LcorpData.php');
require_once(__DIR__ . '/../models/Lcorp/LcorpHtml.php');
require_once(__DIR__ . '/../models/Lcorp/LcorpWord.php');
require_once(__DIR__ . '/../models/Lcorp/LcorpResults.php');

require_once(__DIR__ . '/../models/WWD/WwdData.php');
require_once(__DIR__ . '/../models/WWD/WwdHtml.php');
require_once(__DIR__ . '/../models/WWD/WwdWord.php');

require_once(__DIR__.'/../models/SumInUaData.php');
require_once(__DIR__.'/../models/SumInUaHtml.php');


require_once(__DIR__.'/../models/wordRaw.php');
require_once(__DIR__.'/../models/WordLetters.php');
//require_once(__DIR__.'/../models/wordRaw2.php');

require_once(__DIR__.'/../models/source.php');
require_once(__DIR__.'/../models/wordRawToSource.php');

require_once(__DIR__.'/../models/CapitalWord.php');
