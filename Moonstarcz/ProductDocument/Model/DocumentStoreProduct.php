<?php

namespace Moonstarcz\ProductDocument\Model;

use Magento\Framework\Model\AbstractModel;
use Moonstarcz\ProductDocument\Api\DocumentStoreProductInterface;

class DocumentStoreProduct extends AbstractModel implements DocumentStoreProductInterface
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel\DocumentStoreProduct::class);
    }

    public function loadByDocumentProduct($documentId, $productId)
    {
        $collection = $this->getCollection()
            ->addFieldToFilter(DocumentStoreProductInterface::DOCUMENT_ID, $documentId)
            ->addFieldToFilter(DocumentStoreProductInterface::PRODUCT_ID, $productId);
        $item = $collection->getFirstItem();
        $this->setData($item->getData());
        return $this;
    }
}
