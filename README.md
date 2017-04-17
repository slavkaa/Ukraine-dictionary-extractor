# Ukraine dictionary extractor

Скоро тут з'явиться посилання на репозіторій з MySQL базою українських слів.

Данний репозиторій, це набір PHP скриптів, за допомогою яких я збираю і обробляю слова з текстів і сторінки з веб слловників.

----
[Структура таблиць БД](https://github.com/slavkaa/Ukraine-dictionary-extractor/blob/master/Readme/db_structure.md)
----

База створюється для полегшення роботи ппрограмістів, якім потрібно мати достовірну  актуальну базу українсього правопису. Наприклад, для створення ігор за словами: на складання слів з літер, пошук слів серед літер, автоматизованого складання кросвордів.

Для кожного слова буде вказана частина мови і характеристики притаманні цій частині мови. Слова будуть об'єднані так, шоб можна було легко знайти всі відмінки і числа іменника (те саме з формами нших частин мови). Також у БД будуть вказані тексти, в яких кожне слово було знайдене.

Данна база будується на базі текстів з ukrlib.com.ua та onlyart.org.ua, а також данних словника slovnyk.ua. 

Данна база вирізняється тим, що буде будуватися на основі лексики знайденої в текстах. Наразі це твори Івана Франка.

В планах:
- додати тлумачення до кожного слова 
- додати таблицю з частотами вживання слова у кожному конкретному тесті, і в усіх тестах загалом
- обробити твори Шевченка
- виокремити слова пові'язані з календарем: дні тиждня, місяці
- виокремити назви всіх країн світу
- виокремити словник імен
- виокремити словник міст
- виокремити словник географічних топонімів взагалі
- виокремити словник назв живності
- виокремити словник назв музичних інструментів
- виокремити словник назв професій

