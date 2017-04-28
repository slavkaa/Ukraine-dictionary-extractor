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

    /**
     * @param string $partOfLanguage
     * @param string $sing
     *
     * @return integer|null
     */
    public function countPartOfLanguage($partOfLanguage, $sing = '=')
    {
        $sql = 'SELECT count(*) FROM `' . $this->tableName . '` WHERE part_of_language ' . $sing .' :part_of_language'
            .' AND is_has_html_cut = 1 AND is_need_processing = 1;';

        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return is_array($result) ? (int) reset($result) : null;
    }

    /**
     * @param string $partOfLanguage
     * @param int $limit
     * @param int $offset
     * @param string $sing
     * @return PDOStatement
     */
    public function getPartOfLanguage($partOfLanguage, $limit = 1000000, $offset = 0, $sing = '=')
    {
        echo "offset $offset, limit $limit \n";

        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE part_of_language ' . $sing .' :part_of_language '
            . ' AND is_need_processing = 1 LIMIT :offset, :limit;';

        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stm->bindParam(':part_of_language', $partOfLanguage, PDO::PARAM_STR);
        $stm->execute();

        return $stm;
    }

    /**
     *
     */
    public function backHtmlRowsToProcessing()
    {
        $sql = 'UPDATE `' . $this->tableName . '` SET is_need_processing = 1 WHERE is_has_html_cut = 1 AND is_in_results = 0;';
        $stm = $this->connection->query($sql);
    }
}