<?php

namespace Moonstarcz\ProductDocument\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Message\ManagerInterface;
use Moonstarcz\ProductDocument\Model\DocumentStoreProductFactory;
use Moonstarcz\ProductDocument\Model\ResourceModel\DocumentStoreProduct\CollectionFactory;
use Moonstarcz\Document\Model\ResourceModel\Document\CollectionFactory as DocumentCollectionFactory;

class Data extends AbstractHelper
{
    /**
     * @var DocumentStoreProductFactory
     */
    protected $documentStoreProductFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var DocumentCollectionFactory
     */
    protected $documentCollectionFactory;

    private ManagerInterface $messageManager;

    public function __construct(
        Context $context,
        DocumentStoreProductFactory $documentStoreProductFactory,
        CollectionFactory $collectionFactory,
        DocumentCollectionFactory $documentCollectionFactory,
        ManagerInterface $messageManager
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->documentStoreProductFactory = $documentStoreProductFactory;
        $this->documentCollectionFactory = $documentCollectionFactory;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function assignProductDocuments($documents, $productId)
    {
        $documentProducts = $this->documentStoreProductFactory->create();

        if ($productId && $documents->getSize() > 0) {
            foreach ($documents as $document) {
                $documentId = $document->getId();
                $documentProducts->loadByDocumentProduct($documentId, $productId);
                $documentProducts->setDocumentId($documentId);
                $documentProducts->setCourseId($productId);
                $documentProducts->save();
                $documentProducts->setId(null);
                $productDocumentIds[] = $document->getId();
            }
        }

        return $this;
    }

    public function deleteDocument($documentIds, $productId)
    {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('document_id', ['in' => $documentIds])
            ->addFieldToFilter('course_id', $productId);

        if ($collection) {
            foreach ($collection as $item) {
                $item->delete();
            }
        }
    }
}
