<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Moonstarcz\Course\Controller\Adminhtml\Classroom;

class Delete extends \Moonstarcz\Course\Controller\Adminhtml\Moonstarczclass
{

    /**
     * @var \Moonstarcz\Course\Model\MoonstarczClassFactory
     */
    private $moonstarczClass;

    /**
     * @var \Magento\Backend\App\Action\Context
     */
    private $actionContext;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        \Moonstarcz\Course\Model\MoonstarczClassFactory $moonstarczClass,
        \Magento\Backend\App\Action\Context $actionContext,
        \Magento\Framework\Registry $registry
    )
    {
        $this->registry = $registry;
        $this->moonstarczClass = $moonstarczClass;
        parent::__construct($actionContext , $registry);
        
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->moonstarczClass->create();
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Class.'));
                // go to grid
                return $resultRedirect->setPath('moonstarcz/classroom/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('moonstarcz/classroom/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Class to delete.'));
        // go to grid
        return $resultRedirect->setPath('moonstarcz/classroom/');
    }
}
