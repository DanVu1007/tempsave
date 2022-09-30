<?php

namespace Moonstarcz\ProductClass\Observer\Product;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Moonstarcz\ProductClass\Helper\Data;
use Moonstarcz\ProductClass\Model\ResourceModel\ClassStoreProduct\CollectionFactory;
use Moonstarcz\Course\Model\ResourceModel\MoonstarczClass\CollectionFactory as ClassCollectionFactory;

class Save implements ObserverInterface
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ClassCollectionFactory
     */
    protected $classCollectionFactory;

    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;

    /**
     * Save constructor.
     * @param Data $helperData
     * @param CollectionFactory $collectionFactory
     * @param MessageManagerInterface $messageManager
     * @param ClassCollectionFactory $classCollectionFactory
     */
    public function __construct(
        Data $helperData,
        CollectionFactory $collectionFactory,
        MessageManagerInterface $messageManager,
        ClassCollectionFactory $classCollectionFactory
    ) {
        $this->messageManager = $messageManager;
        $this->collectionFactory = $collectionFactory;
        $this->classCollectionFactory = $classCollectionFactory;
        $this->helperData = $helperData;
    }

    /**
     * @param Observer $observer
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        $productId = $observer->getEvent()->getProduct()->getId();

        $controller = $observer->getEvent()->getController();
        $params = $controller->getRequest()->getParam('fieldset_classes');

        if (isset($params['classes'])) {
            $classIds = [];
            $classes = $params['classes'];
            foreach ($classes as $class) {
                $classIds[] = $class['entity_id'];
            }

            $classIds = array_filter($classIds);

            if (count($classIds)) {
                $classCollection = $this->classCollectionFactory->create()
                    ->addFieldToFilter('entity_id', ['in' => $classIds]);

                $this->helperData->assignProductClasses($classCollection, $productId);
            }
        }

        if (isset($params['delete'])) {
            $classIds = [];
            $classIds[] = array_keys($params['delete']);
            $this->helperData->deleteClass($classIds, $productId);
        }
    }
}
