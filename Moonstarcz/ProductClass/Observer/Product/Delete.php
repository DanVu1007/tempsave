<?php

namespace Moonstarcz\ProductClass\Observer\Product;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Moonstarcz\Course\Model\ResourceModel\MoonstarczClass\CollectionFactory;

class Delete implements ObserverInterface
{
    private CollectionFactory $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param Observer $observer
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        $productId = $observer->getEvent()->getProduct()->getId();

        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('course_id', $productId);

        if ($collection) {
            foreach ($collection as $itemClass) {
                $itemClass->setCourseId(0);
                $itemClass->save();
            }
        }
    }
}
