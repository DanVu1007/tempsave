<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Moonstarcz\Document\Controller\Adminhtml\Document;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Moonstarcz\Document\Controller\Adminhtml\MoonstarDocument;
use Moonstarcz\Document\Model\DocumentFactory;

class Delete extends MoonstarDocument
{
    /**
     * @var DocumentFactory
     */
    public $documentFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DocumentFactory $documentFactory
    )
    {
        $this->documentFactory = $documentFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $model = $this->documentFactory->create()->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the Document.'));
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a Document to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
