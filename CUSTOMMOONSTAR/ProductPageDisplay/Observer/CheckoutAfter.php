<?php
namespace Moonstarcz\ProductPageDisplay\Observer;

use  Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory;

class CheckoutAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var CollectionFactory
     */
    private $itemCollectionFactory;

    public function __construct(
        CollectionFactory $itemCollectionFactory
    ) {
        $this->itemCollectionFactory = $itemCollectionFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quoteId = $observer->getOrder()->getQuoteId();

        $classIds = $this->getClassIdsByQuoteId($quoteId);

        $items = $observer->getOrder()->getAllItems();
        foreach ($items as $key => $item) {
            $item->setData('class_id', $classIds[$key]);
            $item->save();
        }
    }

    public function getClassIdsByQuoteId($quoteId)
    {
        $classIds = [];
        $itemsCollection = $this->itemCollectionFactory->create();
        $itemsByQuoteId = $itemsCollection->addFieldToFilter('quote_id', ['eq'=>$quoteId]);

        foreach ($itemsByQuoteId as $item) {
            $classIds[] = $item['class_id'];
        }
        return $classIds;
    }
}
