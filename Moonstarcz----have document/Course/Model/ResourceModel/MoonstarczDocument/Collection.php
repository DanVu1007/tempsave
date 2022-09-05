<?php
namespace Moonstarcz\Course\Model\ResourceModel\MoonstarczDocument;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'moonstarcz_course_moonstarcz_document_collection';
    protected $_eventObject = 'moonstarcz_document_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Moonstarcz\Course\Model\MoonstarczDocument', 'Moonstarcz\Course\Model\ResourceModel\MoonstarczDocument');
    }
}
