<?php

namespace Moonstarcz\ProductClass\Model\Product\DataProvider\Modifiers;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable;

class Meta
{
    /**
     * @var Configurable
     */
    private $configurableProduct;

    /**
     * @var LocatorInterface
     */
    private $locator;

    public function __construct(
        Configurable $configurableProduct,
        LocatorInterface $locator
    ) {
        $this->configurableProduct = $configurableProduct;
        $this->locator = $locator;
    }

    /**
     * @param array $meta
     *
     * @return array
     */
    public function execute($meta)
    {
        $product = $this->locator->getProduct();
        if(!empty($product->getId())) {
            if ($isPartOfConfigurable = (bool)$this->configurableProduct->getParentIdsByChild($product->getId())) {
                $isPartOfConfigurable = $product->getVisibility() == Visibility::VISIBILITY_NOT_VISIBLE;
            }

            if ($isPartOfConfigurable) {
                $meta['fieldset_classes']['arguments']['data']['config']['visible'] = false;
                $meta['fieldset_classes']['arguments']['data']['config']['disabled'] = true;
            }
        }

        return $meta;
    }
}
