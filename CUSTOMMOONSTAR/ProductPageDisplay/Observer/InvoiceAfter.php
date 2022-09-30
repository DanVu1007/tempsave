<?php
namespace Moonstarcz\ProductPageDisplay\Observer;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory;

class InvoiceAfter implements ObserverInterface
{
    const CUSTOMER_CLASS_TABLE = 'moonstarcz_customer_class';
    const CUSTOMER_FIELD = 'customer_id';
    const CLASS_FIELD = 'class_id';
    /**
     * @var CollectionFactory
     */
    private $itemCollectionFactory;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    public function __construct(
        CollectionFactory $itemCollectionFactory,
        ResourceConnection $resourceConnection
    ) {
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->resourceConnection = $resourceConnection;
    }

    public function execute(Observer $observer)
    {
        $orderId = $observer->getData('event')->getData('invoice')->getData('order_id');
        $customerId = $observer->getData('event')->getData('invoice')->getData('customer_id');

        $classIds = $this->getClassIdsByOrderId($orderId);

        $connection  = $this->resourceConnection->getConnection();

        foreach ($classIds as $classId) {
            $data = [
                self::CUSTOMER_FIELD => $customerId,
                self::CLASS_FIELD => $classId
            ];
            $connection->insert(self::CUSTOMER_CLASS_TABLE, $data);
        }
    }

    public function getClassIdsByOrderId($orderId)
    {
        $classIds = [];
        $itemsCollection = $this->itemCollectionFactory->create();
        $itemsByQuoteId = $itemsCollection->addFieldToFilter('order_id', ['eq'=>$orderId]);

        foreach ($itemsByQuoteId as $item) {
            if($item->getClassId()) {
                $classIds[] = $item->getClassId();
            }
        }
        return $classIds;
    }
}
