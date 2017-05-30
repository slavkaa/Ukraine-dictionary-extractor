<?php
require_once('Abstract\AbstractModel.php');
require_once('Traits\ProcessingFieldTrait.php');
require_once('Traits\WordDataTrait.php');

class SumInUaData extends AbstractModel {

    use ProcessingFieldTrait, WordDataTrait;

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