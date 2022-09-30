<?php

namespace Moonstarcz\ProductClass\Model;

use Magento\Framework\Model\AbstractModel;
use Moonstarcz\ProductClass\Api\Data\ClassStoreProductInterface;

class ClassStoreProduct extends AbstractModel implements ClassStoreProductInterface
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel\ClassStoreProduct::class);
    }

    public function loadByClassProduct($classId, $productId)
    {
        $collection = $this->getCollection()
            ->addFieldToFilter('class_id', $classId)
            ->addFieldToFilter('product_id', $productId);
        $item = $collection->getFirstItem();
        $this->setData($item->getData());
        return $this;
    }
}
