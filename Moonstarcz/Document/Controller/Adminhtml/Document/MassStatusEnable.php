<?php

namespace Moonstarcz\Document\Controller\Adminhtml\Document;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Moonstarcz\Document\Model\ResourceModel\Document\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDisable
 */
class MassStatusEnable extends Action
{
    const STATUS_ENABLE = 1;
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
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
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

        foreach ($collection as $item) {
            $item->setStatus(static::STATUS_ENABLE);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $collection->getSize()));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
