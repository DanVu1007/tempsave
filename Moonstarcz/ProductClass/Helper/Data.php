<?php

namespace Moonstarcz\ProductClass\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Message\ManagerInterface;
use Moonstarcz\ProductClass\Model\ClassStoreProductFactory;
use Moonstarcz\ProductClass\Model\ResourceModel\ClassStoreProduct\CollectionFactory;
use Moonstarcz\Course\Model\ResourceModel\MoonstarczClass\CollectionFactory as ClassCollectionFactory;

class Data extends AbstractHelper
{
    /**
     * @var ClassStoreProductFactory
     */
    protected $classStoreProductFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ClassCollectionFactory
     */
    protected $classCollectionFactory;

    private ManagerInterface $messageManager;

    public function __construct(
        Context $context,
        ClassStoreProductFactory $classStoreProductFactory,
        CollectionFactory $collectionFactory,
        ClassCollectionFactory $classCollectionFactory,
        ManagerInterface $messageManager
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->classStoreProductFactory = $classStoreProductFactory;
        $this->classCollectionFactory = $classCollectionFactory;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function assignProductClasses($classes, $productId)
    {
        $classProducts = $this->classStoreProductFactory->create();

        if ($productId && $classes->getSize() > 0) {
            foreach ($classes as $class) {
                $classId = $class->getId();

                $collection = $this->collectionFactory->create()
                    ->addFieldToFilter('class_id', $classId)
                    ->addFieldToFilter('product_id', ['neq' => $productId]);

                if ($collection->getSize()) {
                    $this->messageManager->addError(__('Class ' . $class->getName() . ' has been assigned to another product'));
                } else {
                    $classProducts->loadByClassProduct($classId, $productId);
                    $classProducts->setClassId($classId);
                    $classProducts->setProductId($productId);
                    $classProducts->save();
                    $classProducts->setId(null);
                    $productClassIds[] = $class->getId();
                    $this->saveProductToClass($classId, $productId);
                }
            }
        }

        return $this;
    }

    public function saveProductToClass($classId, $productId)
    {
        $collection = $this->classCollectionFactory->create()
            ->addFieldtoFilter('entity_id', $classId);

        if ($collection->getSize()) {
            foreach ($collection as $item) {
                $item->setCourseId($productId);
                $item->save();
            }
        }
    }

    public function deleteClass($classIds, $productId)
    {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('class_id', ['in' => $classIds])
            ->addFieldToFilter('product_id', $productId);

        if ($collection) {
            foreach ($collection as $item) {
                $classId = $item->getClassId();
                $classCollection = $this->classCollectionFactory->create()
                    ->addFieldToFilter('entity_id', $classId);

                if ($classCollection) {
                    foreach ($classCollection as $itemClass) {
                        $itemClass->setCourseId(0);
                        $itemClass->save();
                    }
                }
                $item->delete();
            }
        }
    }
}
