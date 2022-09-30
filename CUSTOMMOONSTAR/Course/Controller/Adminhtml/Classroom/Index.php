<?php

namespace Moonstarcz\Course\Controller\Adminhtml\Classroom;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Moonstarcz_Course::index';

    const PAGE_TITLE = 'Class Room';

    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__(static::PAGE_TITLE));
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
