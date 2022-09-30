<?php
namespace Moonstarcz\ProductPageDisplay\Plugin\Model\Quote;

use Magento\Catalog\Model\Product\Type\AbstractType;

class Plugin
{
    public function aroundAddProduct(
        \Magento\Quote\Model\Quote $subject, \Closure $proceed,
        \Magento\Catalog\Model\Product $product,
        $request = null,
        $processMode = AbstractType::PROCESS_MODE_FULL
    )
    {
        // code something
        //throw new \Magento\Framework\Exception\LocalizedException(
        //    __('We found an invalid request for adding product to quote.')
        //);
        return $proceed($product,$request,$processMode);
    }
}
