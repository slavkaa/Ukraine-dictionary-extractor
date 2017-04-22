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
