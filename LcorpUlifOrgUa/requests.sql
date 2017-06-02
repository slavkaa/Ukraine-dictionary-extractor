update lcorp_ulif_org_ua_data set is_need_processing = 0;
update lcorp_ulif_org_ua_data set is_need_processing = 1 where id = 120011;
select count(*) from lcorp_ulif_org_ua_data where is_need_processing = 1;

select count(*) from lcorp_ulif_org_ua_data where part_of_language = 'іменник жіночого роду' AND is_need_processing = 1;
select count(*) from lcorp_ulif_org_ua_data where is_need_processing = 0;
select count(*) from lcorp_ulif_org_ua_results;
select count(*) from lcorp_ulif_org_ua_results where is_main_form = 1;
select part_of_language from lcorp_ulif_org_ua_data group by part_of_language;
select * from lcorp_ulif_org_ua_data where part_of_language = 'іменник жіночого роду' order by id desc  limit 1000 ;

select accented_binary, count(accented_binary) as counter from lcorp_ulif_org_ua_results group by accented_binary, part_of_language, kind, genus, number, verb_kind, person having 1 < counter order by counter DESC;

select creature from lcorp_ulif_org_ua_results group by creature; -- +
select genus from lcorp_ulif_org_ua_results group by genus; -- +
select verb_kind from lcorp_ulif_org_ua_results group by verb_kind; -- +
select variation from lcorp_ulif_org_ua_results group by variation; -- +
select class from lcorp_ulif_org_ua_results group by class; -- +
select tense from lcorp_ulif_org_ua_results group by tense;