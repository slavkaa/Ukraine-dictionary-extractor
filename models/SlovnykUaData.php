<?php
require_once('abstractModel.php');
require_once('Traits\ProcessingFieldTrait.php');
require_once('Traits\WordTrait.php');

class SlovnykUaData extends AbstractModel {

    use ProcessingFieldTrait, WordTrait;

    /**
     * @var string
     */
	protected $tableName = 'slovnyk_ua_data';

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