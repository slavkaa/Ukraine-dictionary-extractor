<?php
require_once('abstractModel.php');
require_once('Traits\ProcessingFieldTrait.php');
require_once('Traits\ParserDataTrait.php');

class SumInUaData extends AbstractModel {

    use ProcessingFieldTrait, ParserDataTrait;

    /**
     * @var string
     */
	protected $tableName = 'sum_in_ua_data';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word_id' => null,
        'word' => null,
        'word_binary' => null,
        'url' => null,
        'url_binary' => null,
        'is_need_processing' => null,
    ];
}