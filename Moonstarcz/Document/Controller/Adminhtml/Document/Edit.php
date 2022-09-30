<?php

namespace Moonstarcz\Document\Controller\Adminhtml\Document;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Moonstarcz\Document\Controller\Adminhtml\MoonstarDocument;
use Moonstarcz\Document\Model\DocumentFactory;

class Edit extends MoonstarDocument
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var DocumentFactory
     */
    protected $documentFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Registry $coreRegistry
     * @param DocumentFactory $documentFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Registry $coreRegistry,
        DocumentFactory $documentFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->documentFactory = $documentFactory;
        return parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            $model = $this->documentFactory->create()->load($id);
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Moonstar Document no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $this->initPage($resultPage)->addBreadcrumb(
                $id ? __('Edit Moonstar Document') : __('New Moonstar Document'),
                $id ? __('Edit Moonstar Document') : __('New Moonstar Document')
            );
            $resultPage->getConfig()->getTitle()->prepend(__('Moonstarcz Documents'));
            $resultPage->getConfig()->getTitle()->prepend($model->getName() ? __('Edit Document: %1', $model->getName()) : __('New Document'));
        }

        return $resultPage;
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
