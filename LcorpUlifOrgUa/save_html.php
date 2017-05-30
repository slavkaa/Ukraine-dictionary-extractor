<?php
header('Access-Control-Allow-Origin: *', false); 

require_once('support/_require_once.php');

$word_binary = $_POST['word'];
$page = $_POST['html'];

$data = new LcorpData($dbh);
$data->findByWord($word_binary);

$id = $data->getId();

$htmlData = new LcorpHtml($dbh);
$htmlData->firstOrNew($id, $word_binary);

$htmlData->getByDataId($id); // refresh
$htmlData->updateProperty('html_cut', PDO::PARAM_LOB, $page);

$data->updateProperty('is_has_html', PDO::PARAM_BOOL, true); // we need cut HTML after
$data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false); // we need cut HTML after

file_put_contents('1.txt', $id);