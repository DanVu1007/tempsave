<?php
namespace Moonstarcz\Course\Model\ResourceModel\MoonstarczTeacher;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'moonstarcz_course_moonstarcz_teacher_collection';
    protected $_eventObject = 'moonstarcz_teacher_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Moonstarcz\Course\Model\MoonstarczTeacher', 'Moonstarcz\Course\Model\ResourceModel\MoonstarczTeacher');
    }
}
