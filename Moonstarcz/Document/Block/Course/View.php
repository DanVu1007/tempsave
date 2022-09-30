<?php


namespace Moonstarcz\Document\Block\Course;


use Magento\Framework\View\Element\Template;
use Moonstarcz\Document\Helper\Data;
use Moonstarcz\Document\Model\Config\Source\Status;
use Moonstarcz\ProductDocument\Api\DocumentStoreProductInterface;
use Moonstarcz\Document\Model\ResourceModel\Document\CollectionFactory as DocumentCollectionFactory;
use Moonstarcz\ProductDocument\Model\ResourceModel\DocumentStoreProduct\CollectionFactory as ProductDocumentCollectionFactory;

class View extends Template
{
    public $documentCollection;

    /**
     * @var DocumentCollectionFactory
     */
    public $documentCollectionFactory;

    /**
     * @var ProductDocumentCollectionFactory
     */
    public $productDocumentCollectionFactory;

    /**
     * @var Data
     */
    public $helperData;

    /**
     * View constructor.
     * @param Template\Context $context
     * @param DocumentCollectionFactory $documentCollectionFactory
     * @param ProductDocumentCollectionFactory $productDocumentCollectionFactory
     * @param Data $helperData
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        DocumentCollectionFactory $documentCollectionFactory,
        ProductDocumentCollectionFactory $productDocumentCollectionFactory,
        Data $helperData,
        array $data = []
    )
    {
        $this->documentCollectionFactory = $documentCollectionFactory;
        $this->productDocumentCollectionFactory = $productDocumentCollectionFactory;
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Documents'));
        $collection = $this->getDocumentCollection();
        if ($collection) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'document.list.pager'
            )->setAvailableLimit(array(12 => 12, 24 => 24, 32 => 32))->setShowPerPage(true)->setCollection(
                $collection
            );
            $this->setChild('pager', $pager);
            $collection->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getDocuments()
    {
        return $this->getDocumentCollection();
    }

    private function getDocumentCollection()
    {
        if (!$this->documentCollection) {
            $documentIds = [];
            $productId = $this->getRequest()->getParam('id');
            $collection = $this->productDocumentCollectionFactory->create();
            $collection->addFieldToFilter(DocumentStoreProductInterface::PRODUCT_ID, $productId);
            $collection->getItems();
            foreach ($collection as $item) {
                $documentIds[] = $item['document_id'];
            }

            $documents = $this->documentCollectionFactory->create();
            $page = $this->getRequest()->getParam('p') ? $this->getRequest()->getParam('p') : 1;
            $pageSize = $this->getRequest()->getParam('limit') ? $this->getRequest()->getParam('limit') : 12;
//            $documents->addFieldToFilter('entity_id', ['in' => $documentIds]);
//            $documents->addFieldToFilter('status', Status::ENABLE);
            $documents->setOrder('name', 'ASC');
            $documents->setPageSize($pageSize);
            $documents->setCurPage($page);
            $this->documentCollection = $documents;
        }
        return $this->documentCollection;
    }

    public function getDocumentTag($extension)
    {
        $extension = strtolower($extension);
        if ($extension == 'pdf') {
            return __('PDF Document');
        }
        if (in_array($extension, $this->helperData->getVideoFormat())) {
            return __('Video lectures');
        }
        return __('Document');
    }

    public function getDocumentViewUrl($documentId)
    {
        return $this->getUrl('moonstar/document/view', ['id' => $documentId]);
    }
}
