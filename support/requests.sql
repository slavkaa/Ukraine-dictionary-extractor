select count(*) from word;
select * from word order by word, id ASC;
select * from word order by created_at, word ASC;
select * from word order by created_at DESC, word ASC;

select * from word_to_ignore order by created_at, word ASC;
select * from word_to_ignore WHERE is_processed = 0 order by created_at DESC, word ASC;
select * from word_to_ignore WHERE is_processed = 0 AND is_false_alert = 0 order by word ASC;
select * from word_to_ignore WHERE is_processed = 1 AND is_false_alert = 0 order by word ASC;
select * from word_to_ignore WHERE is_false_alert = 1 order by word ASC;
select * from word_to_ignore WHERE is_processed = 1 AND is_false_alert = 0 order by created_at DESC, word ASC;

UPDATE word_to_ignore SET is_processed = 1 WHERE is_processed = 0;

SELECT * FROM word_to_source ORDER BY source_id DESC;

select * from source;
select * from source order by id DESC;

select count(*) from html;

select * from html where part_of_language is null limit 40;
select * from html where word_id = 2365;

UPDATE html SET is_need_processing = 1 WHERE is_processed = 0;
UPDATE html SET is_need_processing = 1 WHERE html IS NOT NULL;
UPDATE html SET html = null;

select * from html where part_of_language is null and id > 874 order by id asc;

select * from html where part_of_language = 'іменник' order by id limit 10;
select count(*) from html where part_of_language LIKE '%іменник%';
select * from html where url is null;

select count(*) from html where part_of_language LIKE '%іменник%' and main_form_id is null;
select count(*) from html where part_of_language LIKE '%іменник%';
select * from html where part_of_language LIKE '%іменник%' and main_form_id is null and number is not null and is_main_form = 0 limit 100;
select * from html where id = 218352 or main_form_id = 218352;

-- delete from html where created_at > '2017-04-16 00:00:00';

-- Problem:
select * from html where part_of_language LIKE '%іменник%' and created_at < '2017-04-16 00:00:00' and main_form_id is null and is_main_form = 0 limit 100;
select * from html where part_of_language LIKE '%іменник%' and created_at < '2017-04-16 00:00:00' and main_form_id is null and is_main_form = 0 and part_of_language NOT LIKE '%,%' limit 100;

select count(*) from html where part_of_language LIKE '%займенник%';
select * from html where part_of_language LIKE '%частка%' order by id;
select * from html where part_of_language LIKE '%прислівник%' and part_of_language NOT LIKE '%дієприслівник%' and part_of_language NOT LIKE '%дієслово%' order by id;

INSERT INTO word_rejected (word, word_readable, source_id) SELECT word, word_readable, source_id FROM word_new WHERE is_wrong = 0;

CREATE TABLE copy LIKE original;

SELECT word, count(word) as counter FROM html group by word order by counter DESC;

--

select * from html where is_main_form = 1 and word_id is null and id > 405
select * from html where main_form_id = 632 or id = 632
select * from html where word = 'доля'
update html set main_form_id = 51573 where main_form_id = 582
select * from html where main_form_id = 582
select * from html where main_form_id = 51573 or id = 51573

--

update html set creature = null, genus = null, number = null, person = null, kind = null, verb_kind = null, dievidmina = null, class = null, sub_role = null, comparison = null, tense = null, mood = null, is_infinitive = 0, is_main_form = 0, main_form_id = null

-- INSERT * FROM SELECT *

INSERT INTO html (dictionary_id, word_id, word, word_binary, main_form_id, is_wrong_detection, url, url_binary, html, html_cut, is_main_form, is_proper_name, is_foreign, is_need_processing, part_of_language, creature, genus, number, person, kind, verb_kind, dievidmina, class, sub_role, comparison, tense, variation, mood, is_infinitive, is_modal) VALUE SELECT dictionary_id, word_id, word, word_binary, main_form_id, is_wrong_detection, url, url_binary, html, html_cut, is_main_form, is_proper_name, is_foreign, is_need_processing, part_of_language, creature, genus, number, person, kind, verb_kind, dievidmina, class, sub_role, comparison, tense, variation, mood, is_infinitive, is_modal FROM html_old_1

INSERT INTO html_cut (html_id, word, word_binary) SELECT id, word, word_binary FROM html

INSERT INTO slovnyk_ua_results (word_id, word, word_binary, main_form_id, is_wrong_detection, url, url_binary, is_main_form, is_proper_name, is_foreign, is_need_processing, part_of_language, creature, genus, number, person, kind, verb_kind, dievidmina, class, sub_role, comparison, tense, variation, mood, is_infinitive, is_modal)
                         SELECT word_id, word, word_binary, main_form_id, is_wrong_detection, url, url_binary, is_main_form, is_proper_name, is_foreign, is_need_processing, part_of_language, creature, genus, number, person, kind, verb_kind, dievidmina, class, sub_role, comparison, tense, variation, mood, is_infinitive, is_modal FROM html where url is null

INSERT INTO slovnyk_ua_data (word_id, word, word_binary, main_form_id, is_wrong_detection)
                         SELECT word_id, word, word_binary, main_form_id, is_wrong_detection FROM html where url is null