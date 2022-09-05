<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Moonstarcz\Course\Controller\Adminhtml\Teacher;

class Delete extends \Moonstarcz\Course\Controller\Adminhtml\Moonstarczteacher
{

    /**
     * @var \Moonstarcz\Course\Model\MoonstarczTeacher
     */
    private $moonstarczTeacher;

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function __construct(
        \Moonstarcz\Course\Model\MoonstarczTeacher $moonstarczTeacher
    )
    {
        $this->moonstarczTeacher = $moonstarczTeacher;
        
    }
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->moonstarczTeacher;
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Teacher.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Teacher to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
