<?php

namespace Moonstarcz\ProductClass\Model\ResourceModel\ClassStoreProduct;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Moonstarcz\ProductClass\Model\ClassStoreProduct',
            'Moonstarcz\ProductClass\Model\ResourceModel\ClassStoreProduct'
        );
    }
}
