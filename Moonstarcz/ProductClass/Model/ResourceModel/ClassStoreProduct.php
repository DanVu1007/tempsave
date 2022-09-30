<?php

namespace Moonstarcz\ProductClass\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Moonstarcz\ProductClass\Api\Data\ClassInterface;
use Moonstarcz\ProductClass\Api\Data\ClassStoreProductInterface;

class ClassStoreProduct extends AbstractDb
{
    const STATUS_ENABLED = 1;

    protected function _construct()
    {
        $this->_init('moonstar_course_class', ClassStoreProductInterface::COURSE_CLASS_ID);
    }

    public function getClassIdsByProductId(int $productId)
    {
        $select = $this->getConnection()->select()
            ->from(['csp' => $this->getMainTable()])
            ->where('csp.' . ClassStoreProductInterface::PRODUCT_ID . ' = ?', (int)$productId);

        $selectClassIds = $this->getConnection()->select()
            ->from(['csp' => $this->getMainTable()])
            ->where('csp.' . ClassStoreProductInterface::PRODUCT_ID . ' = ?', (int)$productId);

        if (!($classIds = $this->getConnection()->fetchCol($selectClassIds))) {
            return [];
        }

        if ($classIds) {
            $select->joinLeft(
                ['c' => 'moonstarcz_class'],
                'c.' . ClassInterface::ENTITY_ID . '= csp.' . ClassStoreProductInterface::CLASS_ID,
                '*'
            )->where(
                'c.' . ClassInterface::STATUS . '=' . self::STATUS_ENABLED,
            );
        }

        if ($result = $this->getConnection()->fetchAssoc($select)) {
            return $result;
        }

        return [];
    }
}
