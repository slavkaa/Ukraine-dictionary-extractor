﻿<?php

$capitalLetters = ['Й','Ц','У','К','Е','Н','Г','Ш','Щ','З','Х','Ї','Ф','І','В','А','П','Р','О','Л','Д','Ж','Є','Я',
    'Ч','С','М','И','Т','Ь','Б','Ю','Ґ','I','I','Ё','Ъ','Ы','Э',
    'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
    'E','E','E','E','U','U','U','U','O','?','?','Y','C','O','O','O','O','I','I','I','I',
    'A','A','A','A','A'];

$foreignLetters = [
    'A','B','C','D','E','F','G','H','J','I','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
    'a','b','c','d','e','f','g','h','j','i','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
    'e','e','e','e','E','E','E','E',
    'ё','ъ','ы','э','Ё','Ъ','Ы','Э',
];

$foreignLettersWithoutI = [
    'A','B','C','D','E','F','G','H','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
    'a','b','c','d','e','f','g','h','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
    'e','e','e','e','E','E','E','E',
    'ё','Ё','ъ','Ъ','ы','Ы','э','Э',
];

$pronunciationSings = [
    "\t","\n","\r",
    '‚',',','.',':',';','!','?','..','...' ,'…','№','^','~','#','$','%','=','+','*','@','&','|','_','¦',
    '©','®','™','•','°','§','Ђ','џ','Ћ','‡','‹','Љ','ђ','■','£','ł','±',
    'Ö','ö','ź','è','ę','ż','ś','ć','é',
    '«','»','“','”','/','„','\\',
    '(',')','{','}','[',']','<','>',
    '— ',' —','—','– ',' –',' -','- ','–',' -',' -',' `','` ',
    " '","' ",'" ',' "',' ’','’ ',' ‘','‘ ',
    '  ','  ','  ','  ','  '," "/*&nbsp*/,
];

$ukraineAbc = [
    'а','б','в','г','ґ','д','е','є','ж','з','і','ї','й','и','к','л','м','н','о','п','р','с','т','у','ф','х','ч','ц','ш','щ','ь','ю','я',
    'А','Б','В','Г','Ґ','Д','Е','Є','Ж','З','І','Ї','Й','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ч','Ц','Ш','Щ','Ь','Ю','Я',
    '`', '-',
];

$accentedLetters =        ['а́','и́','о́','і́','́у́','е́','ї́','є́','Є́','у́','А́','я́','І́',];
$accentedLettersReplace = ['а' ,'и' ,'о' ,'i' ,'у'  ,'е' ,'ї' ,'є' ,'Є' ,'у' ,'А' ,'я' ,'І' ,];

$numbers = [0,1,2,3,4,5,6,7,8,9];

$transliteration = [
    'а' => 'a',
    'б' => 'b',
    'в' => 'v',
    'г' => 'h',
    'ґ' => 'g',
    'д' => 'd',
    'е' => 'e',
    'є' => 'ie',
    'ж' => 'zh',
    'з' => 'z',
    'і' => 'i',
    'ї' => 'yi',
    'й' => 'j',
    'и' => 'y',
    'к' => 'k',
    'л' => 'l',
    'м' => 'm',
    'н' => 'n',
    'о' => 'o',
    'п' => 'p',
    'р' => 'r',
    'с' => 's',
    'т' => 't',
    'у' => 'u',
    'ф' => 'f',
    'х' => 'kh',
    'ч' => 'ch',
    'ц' => 'ts',
    'ш' => 'sh',
    'щ' => 'shch',
    'ь' => 'soft_mark',
    'ю' => 'iu',
    'я' => 'ia',
    '`' => 'apostrophe',
];

$transliterationExtended = array_merge($transliteration, [
//    "'" => 'apostrophe',
    '-' => 'hyphen',
    ' ' => 'space',
//    ' ' => 'space', /*&nbsp*/
]);

// ***

$countriesAttended = ['Афганіста́н','Алба́нія','Алжи́р','Андо́рра','Анґі́лла','Анта́рктика','Анти́ґуа і Барбу́да'
    ,'Аргенти́на','Вірме́нія','Ару́ба','Австра́лія','А́встрія','Азербайджа́н','Бага́ми','Бахре́йн','Бангладе́ш'
    ,'Барбадо́с','Білору́сь','Білору́сія','Бе́льгія','Белі́з','Бені́н','Берму́да','Бута́н','Болі́вія'
    ,'Бо́снія і Герцеґови́на','Ботсва́на','Брази́лія','Бруне́й Даруссала́м','Болга́рія','Буркіна́ Фасо́'
    ,'Буру́нді','Камбо́джа','Камеру́н','Кана́да','Ка́по Ве́рде','Кайма́нові острови́','Центра́льна Африка́нська Респу́бліка'
    ,'Чад','Чи́лі','Кита́й','Різдвя́ні острови́','Колу́мбія','Комо́ри','Ко́нго','Ку́ка,острови́','Ко́ста Рі́ка'
    ,'Кот д`Івуа́р','Хорва́тія','Кіпр','Че́ська Респу́бліка','Да́нія','Джибу́ті','Домі́ніка','Домініка́нська Респу́бліка'
    ,'Схі́дний Тимо́р','Еквадо́р','Єги́пет','Ель Сальвадо́р','А́нглія','Екваторіа́льна Ґвіне́я','Еритре́я','Іспа́нія'
    ,'Есто́нія','Ефіо́пія','Фолкле́ндські острови́','Фаре́рські острови́','Фі́джі','Фінля́ндія','Фра́нція','Ґабо́н'
    ,'Ґа́мбія','Гру́зія','Німе́ччина','Ґа́на','Ґібралта́р','Вели́ка Брита́нія','Гре́ція','Ґренла́ндія','Ґрена́да'
    ,'Ґваделу́па','Ґуа́м','Ґватема́ла','Ґвіне́я','Ґвіне́я-Бісса́у','Ґвіа́на','Гаї́ті','Гондура́с','Гон-Ко́нґ'
    ,'Уго́рщина','Ісла́ндія','І́ндія','Індоне́зія','Іра́н','Іра́к','Ірла́ндія','Ізра́їль','Іта́лія','Яма́йка'
    ,'Япо́нія','Іорда́нія','Казахста́н','Ке́нія','Кіріба́ті','Коре́йська Респу́бліка','Коре́я (Півде́нна)'
    ,'Куве́йт','Киргизста́н','Лао́ська Наро́дно-Демократи́чна Респу́бліка','Ла́твія','Лива́н','Лесо́то'
    ,'Лібе́рія','Ліхтенште́йн','Литва́','Люксембу́рг','Мака́о','Македо́нія','Мадагаска́р','Мала́ві','Мала́йзія'
    ,'Мальди́ви','Малі́','Ма́льта','Марша́ллові острови́','Марти́ніка','Маврита́нія','Ме́ксика'
    ,'Мікроне́зія (Федера́льні Шта́ти)','Молдо́ва,Респу́бліка','Мона́ко','Монго́лія','Маро́кко','Мозамбі́к'
    ,'Намі́бія','Нау́ру','Непа́л','Нідерла́нди','Нова́ Каледо́нія','Нова́ Зела́ндія','Нікара́гуа','Ніге́рія'
    ,'Півні́чна Ірла́ндія','Норве́гія','Ома́н','Пакі́стан','Пала́у','Пана́ма','Папуа́ Нова́ Ґвіне́я','Парагва́й'
    ,'Перу́','Філіппі́ни','По́льща','Португа́лія','Пуе́рто Рі́ко','Ката́р','Реуніо́н','Руму́нія','Росі́я'
    ,'Росі́йська Федера́ція','Руа́нда','Са́нта Люсі́я','Сент Вінсе́нт і Ґренаді́ни','Само́а','Сан Марі́но'
    ,'Сау́дівська Ара́вія','Шотла́ндія','Сенега́л','Сейше́ли','Сьє́рра Лео́не','Сингапу́р','Слова́ччина','Слове́нія'
    ,'Соломо́нові острови́','Сомалі́','Півде́нна А́фрика','Півде́нна Коре́я','Іспа́нія','Шрі Ла́нка','Суріна́м'
    ,'Свазиле́нд','Шве́ція','Швейца́рія','Тайва́нь','Таджикіста́н','Танза́нія','Таїла́нд','То́ґо','То́нґа','Триніда́д'
    ,'Триніда́д і Тоба́ґо','Туні́с','Туре́ччина','Туркменіста́н','Тува́лу','Уґа́нда','Украї́на'
    ,'Об`є́днані Ара́бські Еміра́ти','Об`є́днане Королі́вство','Сполу́чені Шта́ти Аме́рики','Уругва́й','США'
    ,'Узбекіста́н','Вануа́ту','Ватика́н,Місто-Держа́ва','Венесуе́ла','В`єтна́м','Уе́льс','За́хідна Саха́ра'
    ,'Є́мен','Югосла́вія','За́мбія','Зимба́бве'];

$partOfLanguage = ['займенник','іменник','прикметник','дієслово','дієприкметник','дієприслівник','прислівник',
    'частка','вигук','сполучник','прийменник','числівник'];

$genus = ['чоловічий','жіночий','середній'];

$number = ['однина','множина'];

$case = ['називний','родовий','давальний','знахідний','орудний','місцевий','кличний'];

$pronounClass = ['особовий','зворотній','взаємний','присвійний','вказівний','означальний','питальний',
    'відносний','неозначений','заперечний'];

$subRole = ['іменник','прикметник','числівник','прислівник'];

$comparisonDegree = ['перший','вищий простий','вищий складений','найвищий простий','найвищий складений'];

$tenses = ['давноминулий','минулий','теперешній','майбутній'];

$verbMood = ['дійсний','умовний','наказовий'];


