<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Moonstarcz\Document\Controller\Course;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Moonstarcz\Document\Helper\Data;

class View implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var Session
     */
    protected $customerSession;
    /**
     * @var Data
     */
    protected $helperData;
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    public function __construct(
        PageFactory $resultPageFactory,
        Session $customerSession,
        Data $helperData,
        ResultFactory $resultFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        $this->helperData = $helperData;
        $this->resultFactory = $resultFactory;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $customer = $this->customerSession->getCustomer();
        if (!$this->helperData->isLoggedIn() || !$this->helperData->isAllowCustomer($customer)) {
            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl('/customer/account/login');
            return $redirect;
        }
        return $this->resultPageFactory->create();
    }
}
