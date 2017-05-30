update lcorp_ulif_org_ua_data set is_need_processing = 0;
update lcorp_ulif_org_ua_data set is_need_processing = 1 where id = 120011;
select count(*) from lcorp_ulif_org_ua_data where is_need_processing = 1;

select count(*) from lcorp_ulif_org_ua_data where part_of_language = 'іменник жіночого роду' AND is_need_processing = 1;
select count(*) from lcorp_ulif_org_ua_data where is_need_processing = 0;
select count(*) from lcorp_ulif_org_ua_results;
select count(*) from lcorp_ulif_org_ua_results where is_main_form = 1;
select part_of_language from lcorp_ulif_org_ua_data group by part_of_language;
select * from lcorp_ulif_org_ua_data where part_of_language = 'іменник жіночого роду' order by id desc  limit 1000 ;
