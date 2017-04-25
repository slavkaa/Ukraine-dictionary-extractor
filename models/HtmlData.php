<?php
require_once('abstractModel.php');

class HtmlData extends AbstractModel {

    /**
     * @var string
     */
	protected $tableName = 'html_data';

    /**
     * @var mixed[]
     */
    protected $props = [
        'html_id' => null,
        'word' => null,
        'word_binary' => null,
        'html' => null,
        'html_cut' => null,
    ];

    /**
     *
     */
    public function getByHtmlId($id)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '` WHERE html_id = :id;';
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $this->id = array_get($result, 'id');
        $this->props = $result;
    }
}