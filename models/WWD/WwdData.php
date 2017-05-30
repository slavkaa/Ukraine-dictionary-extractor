<?php
require_once(__DIR__ . '/../Abstract/AbstractDictionaryData.php');

class WwdData extends AbstractDictionaryData
{
    /**
     * @var string
     */
	protected $tableName = 'worldwidedictionary_org_data';

    /**
     *
     */
    public function setDownloadedHtmlRowsToPartOfLanguageProcessing()
    {
        $sql = 'UPDATE `' . $this->tableName . '` SET is_need_processing = 1 where';
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
        $sql .= ' part_of_language is not null and is_in_results = 0 and is_no_data_in_web = 0;';

        $this->connection->query($sql);
    }
}