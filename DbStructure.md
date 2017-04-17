# Структура бази даних

Основною є таблиця слів 'word'.

|Колонка |Тип |Призначення | 
|---|---|
|id` |int(11) NOT NULL AUTO_INCREMENT | |
|word` |varbinary(255) NOT NULL  | 'Щоб враховувати написання з великої літери' |
|accented` |varbinary(255) DEFAULT NULL | |
|is_wrong` |tinyint(1) NOT NULL DEFAULT '0' |
|is_main_form` |tinyint(1) DEFAULT NULL | Чи є данне слово основною формою слова (для іменника це - чоловічий рід, називний відмінок однини)|
|is_proper_name` |tinyint(1) DEFAULT NULL | Чи це власна назва|
|part_of_language` |enum('займенник','іменник','прикметник','дієслово','дієприкметник','дієприслівник','прислівник','частка','вигук','сполучник','прийменник','числівник') DEFAULT NULL | |
|genus` |enum('чоловічий','жіночий','середній') DEFAULT NULL  | Рід |
|number` |enum('однина','множина') DEFAULT NULL | Число|
|case` |enum('називний','родовий','давальний','знахідний','орудний','місцевий','кличний') DEFAULT NULL  | Відмінок |
|class` |enum('особовий','зворотній','взаємний','присвійний','вказівний','означальний','питальний','відносний','неозначений','заперечний') DEFAULT NULL | |
|sub_role` |enum('іменник','прикметник','числівник','прислівник') DEFAULT NULL | |
|comparison` |enum('перший','вищий простий','вищий складений','найвищий простий','найвищий складений') DEFAULT NULL |Ступінь порівняння |
|tense` |enum('перший','вищий простий','вищий складений','найвищий простий','найвищий складений') DEFAULT NULL | |
|mood` |enum('дійсний','умовний','наказовий') DEFAULT NULL  | Спосіб |
|is_infinitive` |tinyint(1) DEFAULT NULL |Чи слово є інфінитивом |
|created_at` |datetime NOT NULL DEFAULT CURRENT_TIMESTAMP | |
|updated_at` |datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | |
