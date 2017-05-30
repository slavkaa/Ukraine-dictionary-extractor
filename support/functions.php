<?php

/**
 *
**/
function pdoSet($allowed, &$values, $source = array()) {
    $set = '';
    $values = array();
    if (!$source) $source = &$_POST;
    foreach ($allowed as $field) {
        if (isset($source[$field])) {
            $set.="`".str_replace("`","``",$field)."`". "=:$field, ";
            $values[$field] = $source[$field];
        }
    }
    return substr($set, 0, -2);
}

/**
 *
**/
function array_in_string($array, $string)
{
    foreach ($array as $element) {
        if (strpos($string, (string)$element) !== FALSE) {
            return true;
        }
    }
    return false;
}

/**
 * @param string $text
 * @param string[] $accentedLetters
 *
 * @return bool
 */
function isAttended($text, $accentedLetters)
{
    foreach ($accentedLetters as $attended) {
        if (-1 < strpos($text, $attended)) {
            return true;
        }
    }

    return false;
}

/**
 * @param string $text
 * @param string[] $accentedLetters
 * @param string[] $accentedLettersReplace
 *
 * @return bool
 */
function clearAttended($text, $accentedLetters, $accentedLettersReplace)
{
    return str_replace($accentedLetters, $accentedLettersReplace, $text);
}

/**
 * @param mixed $text
 *
 * @return bool
 */
function writeInline($text)
{
    if (is_array($text)) {
        echo json_encode($text). " || ";
    } else {
        echo  $text. " || ";
    }
}

/**
 * @param mixed $text
 *
 * @return bool
 */
function writeLn($text)
{
    if (is_array($text)) {
        echo json_encode($text). "\n";
    } else {
        echo  $text. "\n";
    }
}

/**
 * @param mixed $text
 *
 * @return bool
 */
function cleanCyrillic($text)
{
    $text = str_replace(['i', 'I'], ['і', 'І'], $text); // See Issue #2 (Ukraine-dictionary-extractor)
    return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
}

/**
 * @param mixed $text
 *
 * @return bool
 */
function cleanCyrillicTrue($text)
{
    return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
}

/**
 * @param array $array
 * @param string $key
 * @param mixed $default
 *
 * @return mixed
 */
function array_get($array, $key, $default = null)
{
    if (isset($array[$key])) {
        return$array[$key];
    }

    return $default;
}

/**
 * @param $word
 *
 * @return bool
 */
function isUkrainianWord($word)
{
    global $numbers;
    global $pronunciationSings;
    global $foreignLetters;

    if (array_in_string($numbers, $word)) {
        return false;
    }

    if (array_in_string($pronunciationSings, $word)) {
        return false;
    }

    if (array_in_string($foreignLetters, $word)) {
        return false;
    }

    if (array_in_string(['ІІ'], $word)) { // ІІІамілем
        return false;
    }

    if (2 < substr_count($word, '-')) {
        return false;
    }

    $firstLetter = mb_substr($word, 0);

    if (in_array($firstLetter, ['-'])) {
        return false;
    }

    return true;
}
//
//function cp1251_to_utf8($txt)
//{
//    global $in_arr, $out_arr;
//
//    $txt = str_replace($in_arr,$out_arr,$txt);
//    return $txt;
//}
//
//function unicod($str) {
//    $conv=array();
//    for($x=128;$x<=143;$x++) $conv[$x+112]=chr(209).chr($x);
//    for($x=144;$x<=191;$x++) $conv[$x+48]=chr(208).chr($x);
//    $conv[184]=chr(209).chr(145); #ё
//    $conv[168]=chr(208).chr(129); #Ё
//    $conv[179]=chr(209).chr(150); #і
//    $conv[178]=chr(208).chr(134); #І
//    $conv[191]=chr(209).chr(151); #ї
//    $conv[175]=chr(208).chr(135); #ї
//    $conv[186]=chr(209).chr(148); #є
//    $conv[170]=chr(208).chr(132); #Є
//    $conv[180]=chr(210).chr(145); #ґ
//    $conv[165]=chr(210).chr(144); #Ґ
//    $conv[184]=chr(209).chr(145); #Ґ
//    $ar=str_split($str);
//    foreach($ar as $b) if(isset($conv[ord($b)])) $nstr.=$conv[ord($b)]; else $nstr.=$b;
//    return $nstr;
//}
//
//function CP1251toUTF8($string){
//    $out = '';
//    for ($i = 0; $i<strlen($string); ++$i){
//        $ch = ord($string{$i});
//        if ($ch < 0x80) $out .= chr($ch);
//        else
//            if ($ch >= 0xC0)
//                if ($ch < 0xF0)
//                    $out .= "\xD0".chr(0x90 + $ch - 0xC0); // &#1040;-&#1071;, &#1072;-&#1087; (A-YA, a-p)
//                else $out .= "\xD1".chr(0x80 + $ch - 0xF0); // &#1088;-&#1103; (r-ya)
//            else
//                switch($ch){
//                    case 0xA8: $out .= "\xD0\x81"; break; // YO
//                    case 0xB8: $out .= "\xD1\x91"; break; // yo
//                    // ukrainian
//                    case 0xA1: $out .= "\xD0\x8E"; break; // &#1038; (U)
//                    case 0xA2: $out .= "\xD1\x9E"; break; // &#1118; (u)
//                    case 0xAA: $out .= "\xD0\x84"; break; // &#1028; (e)
//                    case 0xAF: $out .= "\xD0\x87"; break; // &#1031; (I..)
//                    case 0xB2: $out .= "\xD0\x86"; break; // I (I)
//                    case 0xB3: $out .= "\xD1\x96"; break; // i (i)
//                    case 0xBA: $out .= "\xD1\x94"; break; // &#1108; (e)
//                    case 0xBF: $out .= "\xD1\x97"; break; // &#1111; (i..)
//                    // chuvashian
//                    case 0x8C: $out .= "\xD3\x90"; break; // &#1232; (A)
//                    case 0x8D: $out .= "\xD3\x96"; break; // &#1238; (E)
//                    case 0x8E: $out .= "\xD2\xAA"; break; // &#1194; (SCH)
//                    case 0x8F: $out .= "\xD3\xB2"; break; // &#1266; (U)
//                    case 0x9C: $out .= "\xD3\x91"; break; // &#1233; (a)
//                    case 0x9D: $out .= "\xD3\x97"; break; // &#1239; (e)
//                    case 0x9E: $out .= "\xD2\xAB"; break; // &#1195; (sch)
//                    case 0x9F: $out .= "\xD3\xB3"; break; // &#1267; (u)
//                }
//    }
//    return $out;
//}
//
//function win2utf($str)
//{
//    $utf = "";
//    for($i = 0; $i < strlen($str); $i++)
//    {
//        $donotrecode = false;
//        $c = ord(substr($str, $i, 1));
//        if ($c == 0xA8) $res = 0xD081;
//        elseif ($c == 0xB8) $res = 0xD191;
//        elseif ($c < 0xC0) $donotrecode = true;
//        elseif ($c < 0xF0) $res = $c + 0xCFD0;
//        else $res = $c + 0xD090;
//        $utf .= ($donotrecode) ? chr($c) : (chr($res >> 8) . chr($res & 0xff));
//    }
//    return $utf;
//}
//
//function unicode2html($string) {
//    return preg_replace('/\\\\u([0-9a-z]{4})/', '&#x$1;', $string);
//}

function strToHex($string)
{
$hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}