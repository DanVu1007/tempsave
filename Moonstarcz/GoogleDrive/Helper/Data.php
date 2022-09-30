<?php


namespace Moonstarcz\GoogleDrive\Helper;


use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{

    const XML_PATH_CLIENT_ID = 'google_drive/general/client_id';
    const XML_PATH_CLIENT_EMAIL = 'google_drive/general/client_email';
    const XML_PATH_SIGNING_KEY = 'google_drive/general/signing_key';
    const XML_PATH_SERVICE_ACCOUNT_KEY = 'google_drive/general/service_account_key';

    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    public $directoryList;
    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    public $jsonSerializer;

    public function __construct(
        Context $context,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
    )
    {
        $this->directoryList = $directoryList;
        $this->jsonSerializer = $jsonSerializer;
        parent::__construct($context);
    }

    public function getClientId()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CLIENT_ID);
    }

    public function getClientEmail()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CLIENT_EMAIL);
    }

    public function getSigningKey()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SIGNING_KEY);
    }

    public function getServiceAccountKey()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SERVICE_ACCOUNT_KEY);
    }

    public function getServiceAccountKeyFilePath()
    {
        $mediaPath = $this->directoryList->getPath('media');
        $serviceAccountKeyUrl = $this->getServiceAccountKey();
        return $mediaPath . '/moonstar/' . $serviceAccountKeyUrl;
    }
    public function getAuthConfig(){
        $servicePath = $this->getServiceAccountKeyFilePath();
        $serviceConfig = file_get_contents($servicePath);
        return $this->jsonSerializer->unserialize($serviceConfig);
    }
}
