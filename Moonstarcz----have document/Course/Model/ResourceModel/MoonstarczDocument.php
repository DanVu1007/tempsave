<?php
namespace Moonstarcz\Course\Model\ResourceModel;

class MoonstarczDocument extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('moonstarcz_document', 'entity_id');
    }
}