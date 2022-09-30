<?php

namespace Moonstarcz\SearchFormMini\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    protected $searchConfigProvider;

    public function __construct(
        \Magento\Search\ViewModel\ConfigProvider $searchConfigProvider
    ) {
        $this->searchConfigProvider = $searchConfigProvider;
    }

    public function getSearchconfigProvider()
    {
        return $this->searchConfigProvider;
    }

}