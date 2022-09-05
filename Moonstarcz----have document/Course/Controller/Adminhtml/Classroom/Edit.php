<?php
namespace Moonstarcz\Course\Controller\Adminhtml\Classroom;

class Edit extends \Moonstarcz\Course\Controller\Adminhtml\Moonstarczclass
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Moonstarcz\Course\Model\MoonstarczClassFactory
     */
    private $moonstarczClass;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Moonstarcz\Course\Model\MoonstarczClassFactory $moonstarczClass
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->moonstarczClass = $moonstarczClass;
        return parent::__construct($context,$coreRegistry);
    }

   /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->moonstarczClass;
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Class no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('moonstarcz_course_moonstarcz_class', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
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
