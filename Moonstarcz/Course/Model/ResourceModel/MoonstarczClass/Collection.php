<?php
namespace Moonstarcz\Course\Model\ResourceModel\MoonstarczClass;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'moonstarcz_course_moonstarcz_class_collection';
    protected $_eventObject = 'moonstarcz_class_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Moonstarcz\Course\Model\MoonstarczClass', 'Moonstarcz\Course\Model\ResourceModel\MoonstarczClass');
    }
}
