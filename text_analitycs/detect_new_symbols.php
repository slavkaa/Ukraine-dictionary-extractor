﻿<?php

// @acton: php detect_new_symbols.php > new_symbols_oh.txt

require_once('../support/_require_once.php');

// *** //

$author = 'Гончар Олесь';
$titles = [
    0 => '9 Травня .txt',
    1 => 'Ілонка.txt',
    2 => 'Безсмертний полтавець.txt',
    3 => 'Берег його дитинства.txt',
    4 => 'Берег любови.txt',
    5 => 'Березневий каламут.txt',
    6 => 'Блакитні вежі Яновського.txt',
    7 => 'Бондарівна.txt',
    8 => 'Бригантина.txt',
    9 => 'Букет.txt',
    10 => 'Весна за Моравою.txt',
    11 => 'Відлито у вогнях душі.txt',
    12 => 'Вічне слово.txt',
    13 => 'Геній Достоєвського.txt',
    14 => 'Гоголь і Україна.txt',
    15 => 'Голос ніжності й правди.txt',
    16 => 'Гори співають.txt',
    17 => 'Дніпровський вітер.txt',
    18 => 'Довженків світ.txt',
    19 => 'Дядько Роман і золотокрилки.txt',
    20 => 'Жайворонок.txt',
    21 => 'Жити йому в віках.txt',
    22 => 'З тих ночей.txt',
    23 => 'За мить щастя.txt',
    24 => 'Завжди солдати.txt',
    25 => 'Залізний острів.txt',
    26 => 'Земля гуде.txt',
    27 => 'Зірниці.txt',
    28 => 'Крапля крові.txt',
    29 => 'Кресафт.txt',
    30 => 'Людина в степу.txt',
    31 => 'Людина і зброя.txt',
    32 => 'Людині гімн.txt',
    33 => 'Літньої ночі.txt',
    34 => 'Маша з верховини.txt',
    35 => 'Микита Братусь.txt',
    36 => 'Модри Камень.txt',
    37 => 'На косі.txt',
    38 => 'Наша Леся.txt',
    39 => 'Нехай живе життя.txt',
    40 => 'Ніч мужності.txt',
    41 => 'Партизанська іскра.txt',
    42 => 'Перекоп.txt',
    43 => 'Поборник справедливості.txt',
    44 => 'Подвиг Каменяра.txt',
    45 => 'Полігон.txt',
    46 => 'Пороги.txt',
    47 => 'Прапороносці.txt',
    48 => 'Птахи над Бродщиною.txt',
    49 => 'Пізнє прозріння .txt',
    50 => 'Романові яблука.txt',
    51 => 'Слово про Буревісника.txt',
    52 => 'Собор.txt',
    53 => 'Солов\'їна сторожа.txt',
    54 => 'Соняшники.txt',
    55 => 'Спогад про Ауезова.txt',
    56 => 'Сусіди.txt',
    57 => 'Таврія.txt',
    58 => 'Твоя зоря.txt',
    59 => 'Тихі води.txt',
    60 => 'Тронка.txt',
    61 => 'Усман та Марта.txt',
    62 => 'Фронтові поезії.txt',
    63 => 'Хлопець із плацдарму.txt',
    64 => 'Хто кого водив.txt',
    65 => 'Циклон.txt',
    66 => 'Чорний яр.txt',
    67 => 'Шевченко і сучасність.txt',
    68 => 'Штрихи до портрета Остапа Вишні.txt',
    69 => 'Щоб світився вогник.txt',
    70 => 'Яблука на стовпцях.txt',
];

$wrongWords = [];

echo "\n";

foreach ($titles as $title) {
    echo $title . ':';

    $filename = sprintf('../texts/%s/%s', $author, $title);

    $filename = iconv(mb_detect_encoding($filename, mb_detect_order(), true), "cp1251", $filename);
    $text = file_get_contents($filename);

    $text = cleanCyrillicTrue($text);

    $word_binary = str_replace($capitalLetters, '', $text);
    $word_binary = str_replace($foreignLetters, '', $word_binary);
    $word_binary = str_replace($pronunciationSings, '', $word_binary);
    $word_binary = str_replace($ukraineAbc, '', $word_binary);
    $word_binary = str_replace($numbers, '', $word_binary);
    $word_binary = str_replace("\xA0", '', $word_binary);
    $word_binary = str_replace('-', '', $word_binary); // it is OK - it is part of legal words
    $word_binary = str_replace('’', '', $word_binary); // it is OK - it is part of legal words
    $word_binary = str_replace('`', '', $word_binary); // it is OK - it is part of legal words
    $word_binary = str_replace('‘', '', $word_binary); // it is OK - it is part of legal words
    $word_binary = str_replace(' ', '', $word_binary);

    if ('' != $word_binary) {
        echo '+';
        $wrongWords[$title] = $word_binary;
    }

    echo "\n\n";
}
//echo "\n";

var_dump($wrongWords);



