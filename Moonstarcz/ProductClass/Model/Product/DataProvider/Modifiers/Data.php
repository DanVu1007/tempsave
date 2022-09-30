<?php

namespace Moonstarcz\ProductClass\Model\Product\DataProvider\Modifiers;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Moonstarcz\ProductClass\Api\Data\ClassInterface;
use Moonstarcz\ProductClass\Model\ResourceModel\ClassStoreProduct;

class Data
{
    const CLASS_FIELDS = [
        ClassInterface::NAME,
        ClassInterface::STATUS,
        ClassInterface::TEACHER_ID,
        ClassInterface::MAX_STUDENT,
        ClassInterface::TOTAL_LESSON,
        ClassInterface::START_DATE,
        ClassInterface::END_DATE,
        ClassInterface::START_TIME,
        ClassInterface::END_TIME
    ];

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var ClassStoreProduct
     */
    private $classStoreProductResource;

    /**
     * Data constructor.
     * @param LocatorInterface $locator
     * @param ClassStoreProduct $classStoreProductResource
     */
    public function __construct(
        LocatorInterface $locator,
        ClassStoreProduct $classStoreProductResource
    ) {
        $this->classStoreProductResource = $classStoreProductResource;
        $this->locator = $locator;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function execute(array $data)
    {
        $data[$this->locator->getProduct()->getId()]['fieldset_classes']['classes'] = $this->getClass();
        return $data;
    }

    /**
     * @return array
     */
    private function getClass()
    {
        $productId = $this->locator->getProduct()->getId();
        $result = [];
        if ($productId) {
            try {
                $classStoreProducts = $this->classStoreProductResource->getClassIdsByProductId($productId);
                if (!empty($classStoreProducts)) {
                    foreach ($classStoreProducts as $item) {
                        if (!empty($result[$item[ClassInterface::ENTITY_ID]])) {
                            continue;
                        }
                        $row = [];
                        $row[ClassInterface::ENTITY_ID] = $row['entity_id'] = $item[ClassInterface::ENTITY_ID];

                        foreach (self::CLASS_FIELDS as $field) {
                                $row[$field] = $item[$field];
                        }

                        $result[$row[ClassInterface::ENTITY_ID]] = $row;
                    }
                }
            } catch (\Exception $e) {
                return  [];
            }
        }

        return array_merge($result);
    }
}
