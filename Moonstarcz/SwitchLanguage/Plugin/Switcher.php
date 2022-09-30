<?php

namespace Moonstarcz\SwitchLanguage\Plugin;

use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\App\State;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\TranslateInterface;
use Magento\Store\Api\StoreCookieManagerInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use MageWorx\GeoIP\Model\Geoip;

class Switcher
{
    const VI_LOCALE = 'vi_VN';
    const CZ_LOCALE = 'cs_CZ';
    const VN_STORE_CODE = "vietnam";
    const CZ_STORE_CODE = "czechia";
    const VIETNAM_COUNTRY_CODE = "VN";
    const FRONTEND_AREA = 'frontend';
    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Geoip
     */
    private $geoIp;

    /**
     * @var TranslateInterface
     */
    private $_translate;

    /**
     * @var State
     */
    private $state;

    public function __construct(
        RemoteAddress $remoteAddress,
        StoreManagerInterface $storeManager,
        \MageWorx\GeoIP\Model\GeoipFactory $geoIp,
        TranslateInterface $translate,
        StoreCookieManagerInterface $storeCookieManager,
        StoreRepositoryInterface $storeRepository,
        HttpContext $httpContext,
        State $state
    ) {
        $this->remoteAddress = $remoteAddress;
        $this->httpContext = $httpContext;
        $this->storeManager = $storeManager;
        $this->geoIp = $geoIp;
        $this->_translate = $translate;
        $this->state = $state;
        $this->storeRepository = $storeRepository;
        $this->storeCookieManager = $storeCookieManager;
    }
    public function beforeDispatch()
    {
        $ipAddress = $this->remoteAddress->getRemoteAddress();
        $geoIp = $this->geoIp->create();
        $countryCode = $geoIp->getLocation($ipAddress)->getCode();

        $areaCode = $this->state->getAreaCode();
        if ($areaCode == self::FRONTEND_AREA) {
            if (isset($countryCode) && $countryCode == self::VIETNAM_COUNTRY_CODE) {
                $this->setStoreView(self::VN_STORE_CODE);
            } else {
                $this->setStoreView(self::CZ_STORE_CODE);
            }
        }
    }

    public function setStoreView($storeView)
    {
        $store = $this->storeRepository->getActiveStoreByCode($storeView);
        $this->httpContext->setValue(Store::ENTITY, $storeView, 'DEFAULT_STORE_CODE');
        $this->storeCookieManager->setStoreCookie($store);
    }
}
