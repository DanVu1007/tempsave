<?php
namespace Moonstarcz\Course\Controller\Adminhtml\Classroom;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Moonstarcz_Course::newaction';
    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var ForwardFactory
     */
    private $forwardFactory;
    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ForwardFactory $forwardFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->resultForwardFactory = $forwardFactory;
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return Forward
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
