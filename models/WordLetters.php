<?php

require_once('abstractModel.php');
require_once('Traits\ProcessingFieldTrait.php');
require_once('Traits\WordDataTrait.php');

class WordLetters extends AbstractModel
{
    use ProcessingFieldTrait, WordDataTrait;

    /**
     * @var string
     */
	protected $tableName = 'word_letters';

    /**
     * @var mixed[]
     */
    protected $props = [
        'word' => null,
        'word_binary' => null,
    ];

    public function updateLetterCounter()
    {
        $word = $this->getProperty('word_binary');
    }
}