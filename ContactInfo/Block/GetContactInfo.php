<?php
namespace Moonstarcz\ContactInfo\Block;

use Magento\Framework\View\Element\Template\Context;

class GetContactInfo extends \Magento\Framework\View\Element\Template
{
    const storeCzId = 1;
    const storeVnId = 2;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    //return array [name,address,phone,image]
    public function getInfoStore()
    {
        return [
            'store_vn_info' => $this->getInfoStoreById(self::storeVnId),
            'store_cz_info' => $this->getInfoStoreById(self::storeCzId),
        ];
    }

    public function getInfoStoreById($storeId)
    {
        $stress = $this->getConfigValue('general/store_information/street_line1',$storeId) . ',' . $this->getConfigValue('general/store_information/street_line2',$storeId);
        $city = $this->getConfigValue('general/store_information/city',$storeId);
        $region = $this->getConfigValue('general/store_information/region_id',$storeId);
        $country = $this->getConfigValue('general/store_information/country_id',$storeId);
        $img = $this->getConfigValue('contact_page/contact_info/image',$storeId);
        $image= $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA )
                . \Moonstarcz\ContactInfo\Model\Config\Backend\Image::UPLOAD_DIR .'/'
                . $this->getConfigValue('contact_page/contact_info/image',$storeId);

        $storeAddress = $stress . $city . ', ' . $region . ', ' . $country;
        return [
            'store_name' => $this->getConfigValue('general/store_information/name',$storeId),
            'store_phone' => $this->getConfigValue('general/store_information/phone',$storeId),
            'store_address' => $storeAddress,
            'store_image' => $image,
        ];
    }

    public function getConfigValue($path,$storeId)
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
