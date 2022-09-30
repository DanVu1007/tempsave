<?php

namespace Moonstarcz\Document\Controller\Adminhtml\Document;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Moonstarcz\Document\Model\ResourceModel\Document\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Moonstarcz_Document::massdelete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory
        $collectionFactory
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute()
    {
        $documentCollection = $this->collectionFactory->create();
        $collection = $this->filter->getCollection($documentCollection);
        $collectionSize = $collection->getSize();

        foreach ($collection as $page) {
            $page->delete();
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
