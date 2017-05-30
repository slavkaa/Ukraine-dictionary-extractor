<?php
require_once(__DIR__ . '/../Abstract/AbstractDictionaryData.php');

class LcorpData extends AbstractDictionaryData
{
    /**
     * @var string
     */
	protected $tableName = 'lcorp_ulif_org_ua_data';

    /**
     *
     */
    public function setDownloadedHtmlRowsToPartOfLanguageProcessing()
    {
        $sql = 'UPDATE `' . $this->tableName . '` SET is_need_processing_part_of_language = 1 where';
        $sql .= ' is_has_html = 1 and is_in_results = 0 and is_no_data_in_web = 0;';

        $this->connection->query($sql);
    }

    /**
     *
     */
    public function setDownloadingProcessing()
    {
        $sql = 'UPDATE `' . $this->tableName . '` SET is_need_processing = 1 where';
        $sql .= ' is_has_html = 0 and is_in_results = 0 and is_no_data_in_web = 0;';

        $this->connection->query($sql);
    }

    /**
     *
     */
    public function setHtmlRowsToMorphologicalProcessing()
    {
        $sql = 'UPDATE `' . $this->tableName . '` SET is_need_processing = 1 where';
        $sql .= ' part_of_language is not null; -- and is_in_results = 0 and is_no_data_in_web = 0;';

        $this->connection->query($sql);
    }

    /**
     * @param int $limit
     * @return PDOStatement
     */
    public function getAllIsNeedPartOfLanguageProcessing($limit = 1000000)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE is_need_processing_part_of_language = 1 LIMIT :limit;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->execute();

        return $stm;
    }



    /**
     * @return integer|null
     */
    public function countIsNeedPartOfLanguageProcessing()
    {
        $sql = 'SELECT count(*) FROM `' . $this->tableName . '` WHERE is_need_processing_part_of_language = 1;';

        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return is_array($result) ? (int) reset($result) : null;
    }
}