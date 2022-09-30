<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Moonstarcz\Course\Controller\Adminhtml\Classroom;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Moonstarcz\Course\Model\MoonstarczClassFactory;

class Delete extends \Moonstarcz\Course\Controller\Adminhtml\MoonstarczClass
{

    /**
     * @var MoonstarczClassFactory
     */
    private $moonstarczClass;

    /**
     * @var Context
     */
    private $actionContext;

    /**
     * @var Registry
     */
    private $registry;

    public function __construct(
        MoonstarczClassFactory $moonstarczClass,
        Context $actionContext,
        Registry $registry
    ) {
        $this->registry = $registry;
        $this->moonstarczClass = $moonstarczClass;
        parent::__construct($actionContext, $registry);
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
