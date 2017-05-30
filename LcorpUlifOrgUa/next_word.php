<?php
header('Access-Control-Allow-Origin: *', false); 

require_once('support/_require_once.php');

$stm = $dbh->query('SELECT word_binary from lcorp_ulif_org_ua_data where is_need_processing = 1 order by id desc limit 1;');

$result = $stm->fetch(PDO::FETCH_ASSOC);

sleep(0.5);
 
echo reset($result);