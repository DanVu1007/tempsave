<?php

namespace Moonstarcz\ProductDocument\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Moonstarcz\Document\Model\Document;
use Moonstarcz\ProductDocument\Api\DocumentStoreProductInterface;

class DocumentStoreProduct extends AbstractDb
{
    const STATUS_ENABLED = 1;

    protected function _construct()
    {
        $this->_init('moonstarcz_course_document', DocumentStoreProductInterface::COURSE_DOCUMENT_ID);
    }

    public function getDocumentIdsByProductId(int $productId)
    {
        $select = $this->getConnection()->select()
            ->from(['dsp' => $this->getMainTable()])
            ->where('dsp.' . DocumentStoreProductInterface::PRODUCT_ID . ' = ?', (int)$productId);

        $selectDocumentIds = $this->getConnection()->select()
            ->from(['dsp' => $this->getMainTable()])
            ->where('dsp.' . DocumentStoreProductInterface::PRODUCT_ID . ' = ?', (int)$productId);

        if (!($documentIds = $this->getConnection()->fetchCol($selectDocumentIds))) {
            return [];
        }

        if ($documentIds) {
            $select->joinLeft(
                ['d' => 'moonstarcz_document'],
                'd.entity_id = dsp.' . DocumentStoreProductInterface::DOCUMENT_ID,
                '*'
            )->where(
                'd.' .Document::STATUS . ' = ' . self::STATUS_ENABLED,
            );
        }

        if ($result = $this->getConnection()->fetchAssoc($select)) {
            return $result;
        }

        return [];
    }
}
