<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Moonstarcz\Course\Controller\Adminhtml\Teacher;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Registry;
use Moonstarcz\Course\Model\MoonstarczTeacherFactory;

class Delete extends \Moonstarcz\Course\Controller\Adminhtml\MoonstarczTeacher
{

    /**
     * @var MoonstarczTeacherFactory
     */
    private $moonstarczTeacher;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * Delete action
     *
     * @param MoonstarczTeacherFactory $moonstarczTeacher
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        MoonstarczTeacherFactory $moonstarczTeacher,
        Context $context,
        Registry $registry
    ) {
        $this->moonstarczTeacher = $moonstarczTeacher;
        parent::__construct($context, $registry);
    }
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->moonstarczTeacher->create();
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Teacher.'));
                // go to grid
                return $resultRedirect->setPath('moonstarcz/teacher/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('moonstarcz/teacher/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Teacher to delete.'));
        // go to grid
        return $resultRedirect->setPath('moonstarcz/teacher/');
    }
}
