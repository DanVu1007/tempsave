<?php
namespace Bssi\CustomLanguage\Plugin;

class Switcher
{
    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */
    private $remoteAddress;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->remoteAddress = $remoteAddress;
        $this->storeManager = $storeManager;
    }
    public function beforeDispatch(){
        $ipAddress = $this->remoteAddress->getRemoteAddress();

        $json       = file_get_contents("http://ipinfo.io/{$ipAddress}/json");
        $details    = json_decode($json);
        $isVN       = false;

        if((isset($details->country) && $details->country == "VN")){
            $isVN = true;
        }
        if($isVN){
            $this->storeManager->setCurrentStore('VN');
        }
    }
}
