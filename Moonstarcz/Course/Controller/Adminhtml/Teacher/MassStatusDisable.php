<?php
namespace Moonstarcz\Course\Controller\Adminhtml\Teacher;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Moonstarcz\Course\Model\ResourceModel\MoonstarczTeacher\CollectionFactory; 
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDisable
 */
class MassStatusDisable extends \Magento\Backend\App\Action
{
    const STATUS_DISABLE = 0;
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
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setStatus(static::STATUS_DISABLE);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('moonstarcz/teacher/');
    }
}