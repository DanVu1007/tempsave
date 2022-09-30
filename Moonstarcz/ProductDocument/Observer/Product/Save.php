<?php

namespace Moonstarcz\ProductDocument\Observer\Product;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Moonstarcz\ProductDocument\Helper\Data;
use Moonstarcz\ProductDocument\Model\ResourceModel\DocumentStoreProduct\CollectionFactory;
use Moonstarcz\Document\Model\ResourceModel\Document\CollectionFactory as DocumentCollectionFactory;

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
     * @var DocumentCollectionFactory
     */
    protected $documentCollectionFactory;

    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;

    /**
     * Save constructor.
     * @param Data $helperData
     * @param CollectionFactory $collectionFactory
     * @param MessageManagerInterface $messageManager
     * @param DocumentCollectionFactory $documentCollectionFactory
     */
    public function __construct(
        Data $helperData,
        CollectionFactory $collectionFactory,
        MessageManagerInterface $messageManager,
        DocumentCollectionFactory $documentCollectionFactory
    ) {
        $this->messageManager = $messageManager;
        $this->collectionFactory = $collectionFactory;
        $this->documentCollectionFactory = $documentCollectionFactory;
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
        $params = $controller->getRequest()->getParam('fieldset_documents');

        if (isset($params['documents'])) {
            $documentIds = [];
            $documents = $params['documents'];
            foreach ($documents as $document) {
                $documentIds[] = $document['entity_id'];
            }

            $documentIds = array_filter($documentIds);

            if (count($documentIds)) {
                $documentCollection = $this->documentCollectionFactory->create()
                    ->addFieldToFilter('entity_id', ['in' => $documentIds]);

                $this->helperData->assignProductDocuments($documentCollection, $productId);
            }
        }

        if (isset($params['delete'])) {
            $documentIds = [];
            $documentIds[] = array_keys($params['delete']);
            $this->helperData->deleteDocument($documentIds, $productId);
        }
    }
}
