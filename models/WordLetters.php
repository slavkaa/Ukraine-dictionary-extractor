<?php

require_once('Abstract\AbstractModel.php');
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

    /**
     *
     */
    public function updateLength()
    {
        $word = $this->getProperty('word_binary');

        $this->updateProperty('length', PDO::PARAM_INT, mb_strlen($word));
    }

    /**
     *
     */
    public function updateLetterCounter()
    {
        global $transliterationExtended;

        $word = mb_strtolower($this->getProperty('word_binary'));

        $length = mb_strlen($word);

        $counter = [];

        for ($i = 0; $i < $length; $i++) {
            $letter = mb_substr($word, $i, 1);

                                      /*&nbsp*/
            $letter = str_replace(["'", ' '],['`', ' '], $letter); // hack

            $n = array_get($counter, $letter);
            $n++;
            $counter[$letter] = $n;
        }
        foreach ($transliterationExtended as $key => $property) {
            $n = (int) array_get($counter, $key);
            $this->updateProperty($property, PDO::PARAM_INT, $n);
        }
    }

    /**
     *
     */
    public function updateLetterPlaces()
    {
        $word = mb_strtolower($this->getProperty('word_binary'));

        $length = mb_strlen($word);

        for ($i = 0; $i < 26; $i++) {
            $letter = mb_substr($word, $i, 1);
            $letter = $letter ? $letter : null;
            $this->updateProperty( ($i+1) , PDO::PARAM_STR, $letter);
        }
    }
}