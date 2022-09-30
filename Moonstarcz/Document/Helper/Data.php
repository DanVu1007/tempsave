<?php


namespace Moonstarcz\Document\Helper;


use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Framework\App\Http\Context as HttpContext;

class Data extends AbstractHelper
{
    /**
     * @var Session
     */
    private $customerSession;
    /**
     * @var HttpContext
     */
    private $httpContext;
    /**
     * @var UserContextInterface
     */
    private $userContext;

    public function __construct(
        Context $context,
        Session $customerSession,
        HttpContext $httpContext,
        UserContextInterface $userContext

    )
    {
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
        $this->userContext = $userContext;
        parent::__construct($context);
    }

    public function isLoggedIn()
    {
        return $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    public function isAllowCustomer($customer, $notify = true)
    {
        return true;
    }

    public function getCustomerLoggedId()
    {
        return $this->customerSession->getCustomer();
    }

    public function getVideoFormat()
    {
        return [
            'ffmpeg', 'divx', 'xvid', 'avi', 'flv', 'wmv', 'mp4', 'mov'
        ];
    }
}
