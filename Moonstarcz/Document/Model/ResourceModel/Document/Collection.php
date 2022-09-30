<?php

namespace Moonstarcz\Document\Model\ResourceModel\Document;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'moonstarcz_Document_moonstarcz_document_collection';
    protected $_eventObject = 'moonstarcz_document_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Moonstarcz\Document\Model\Document::class, \Moonstarcz\Document\Model\ResourceModel\Document::class);
    }
}
