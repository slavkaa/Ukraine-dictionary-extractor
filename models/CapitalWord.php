<?php
require_once('Abstract\AbstractModel.php');
require_once('Traits\WordTrait.php');

class CapitalWord extends AbstractModel {

    use WordTrait;

    /**
     * @var string
     */
	protected $tableName = 'capital_word';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word' => null,
        'word_binary' => null,
        'is_trusted' => null,
    ];
}