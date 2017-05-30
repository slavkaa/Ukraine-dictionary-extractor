<?php
require_once('Abstract\AbstractModel.php');
require_once('Traits\WordTrait.php');
require_once('Traits\ProcessingFieldTrait.php');

class WordRaw extends AbstractModel {

    use WordTrait, ProcessingFieldTrait;

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
        'is_not_urk_word' => null,
        'is_from_dictionary' => null,
    ];
}