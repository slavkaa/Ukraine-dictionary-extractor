<?php
require_once('abstractModel.php');
require_once('Traits\WordTrait.php');

class WordRaw extends AbstractModel {

    use WordTrait;

    /**
     * @var string
     */
	protected $tableName = 'word_raw';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word' => null,
        'word_binary' => null,
    ];
}