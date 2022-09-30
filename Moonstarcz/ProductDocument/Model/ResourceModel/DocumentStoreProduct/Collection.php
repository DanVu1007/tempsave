<?php

namespace Moonstarcz\ProductDocument\Model\ResourceModel\DocumentStoreProduct;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Moonstarcz\ProductDocument\Model\DocumentStoreProduct',
            'Moonstarcz\ProductDocument\Model\ResourceModel\DocumentStoreProduct'
        );
    }
}
