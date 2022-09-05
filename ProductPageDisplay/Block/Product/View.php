<?php
namespace Moonstarcz\ProductPageDisplay\Block\Product;

use Magento\Framework\View\Element\Template\Context;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
