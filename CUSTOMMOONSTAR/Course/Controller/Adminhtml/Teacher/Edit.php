<?php
namespace Moonstarcz\Course\Controller\Adminhtml\Teacher;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Moonstarcz\Course\Model\MoonstarczTeacherFactory;

class Edit extends \Moonstarcz\Course\Controller\Adminhtml\MoonstarczTeacher
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var MoonstarczTeacherFactory
     */
    private $moonstarczTeacher;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Registry $coreRegistry
     * @param MoonstarczTeacherFactory $moonstarczTeacher
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Registry $coreRegistry,
        MoonstarczTeacherFactory $moonstarczTeacher
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->moonstarczTeacher = $moonstarczTeacher;
        return parent::__construct($context, $coreRegistry);
    }

    /**
      * Edit action
      *
      * @return ResultInterface
      */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->moonstarczTeacher->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Teacher no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('moonstarcz/teacher/');
            }
        }
        $this->_coreRegistry->register('moonstarcz_course_moonstarcz_teacher', $model);

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->_pageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Teacher') : __('New Teacher'),
            $id ? __('Edit Teacher') : __('New Teacher')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Teacher'));
        $resultPage->getConfig()->getTitle()->prepend($model->getName() ? __('Edit Teacher: %1', $model->getName()) : __('New Teacher'));
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
