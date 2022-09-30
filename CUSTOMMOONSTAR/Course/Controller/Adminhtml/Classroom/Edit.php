<?php

namespace Moonstarcz\Course\Controller\Adminhtml\Classroom;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Moonstarcz\Course\Model\MoonstarczClassFactory;

class Edit extends \Moonstarcz\Course\Controller\Adminhtml\MoonstarczClass
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
     * @var MoonstarczClassFactory
     */
    private $moonstarczClass;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Registry $coreRegistry
     * @param MoonstarczClassFactory $moonstarczClass
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Registry $coreRegistry,
        MoonstarczClassFactory $moonstarczClass
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->moonstarczClass = $moonstarczClass;
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
        $model = $this->moonstarczClass->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Class no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('moonstarcz/classroom/');
            }
        }
        $this->_coreRegistry->register('moonstarcz_course_moonstarcz_class', $model);

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->_pageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Class') : __('New Class'),
            $id ? __('Edit Class') : __('New Class')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Moonstarcz Class'));
        $resultPage->getConfig()->getTitle()->prepend($model->getName() ? __('Edit Class: %1', $model->getName()) : __('New Class'));
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
