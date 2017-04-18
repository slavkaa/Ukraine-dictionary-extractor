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