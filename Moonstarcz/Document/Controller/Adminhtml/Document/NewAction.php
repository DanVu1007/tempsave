<?php

namespace Moonstarcz\Document\Controller\Adminhtml\Document;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Action
{
    const ADMIN_RESOURCE = 'Moonstarcz_Document::newaction';
    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ForwardFactory $forwardFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->resultForwardFactory = $forwardFactory;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Forward|ResultInterface
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
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
