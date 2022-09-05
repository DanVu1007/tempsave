<?php

namespace Moonstarcz\SwitchLanguage\Plugin;

use Magento\Framework\App\State;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\TranslateInterface;
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
        State $state
    ) {
        $this->remoteAddress = $remoteAddress;
        $this->storeManager = $storeManager;
        $this->geoIp = $geoIp;
        $this->_translate = $translate;
        $this->state = $state;
    }
    public function beforeDispatch()
    {
        $ipAddress = $this->remoteAddress->getRemoteAddress();
        //TEST IP CZECH
        $ipAddress = '5.59.255.255';
        //TEST IP VIETNAM
//        $ipAddress = '222.252.27.212';
        $geoIp = $this->geoIp->create();
        $countryCode = $geoIp->getLocation($ipAddress)->getCode();

        $areaCode = $this->state->getAreaCode();
        if ($areaCode == self::FRONTEND_AREA) {
            if (isset($countryCode) && $countryCode == self::VIETNAM_COUNTRY_CODE) {
                $this->setViLocale();
            } else {
                $this->setCzLocale();
            }
        }
    }

    private function setViLocale()
    {
        $this->_translate->setLocale(self::VI_LOCALE);
//        $this->storeManager->setCurrentStore(self::VN_STORE_CODE);
    }

    private function setCzLocale()
    {
        $this->_translate->setLocale(self::CZ_LOCALE);
//        $this->storeManager->setCurrentStore(self::CZ_STORE_CODE);
    }
}
