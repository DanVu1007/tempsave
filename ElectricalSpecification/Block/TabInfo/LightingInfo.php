<?php

namespace OmnyfyCustomzation\ElectricalSpecification\Block\TabInfo;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Product Review Tab
 *
 * @api
 * @author     Magento Core Team <core@magentocommerce.com>
 * @since      100.0.2
 */
class LightingInfo extends Template implements IdentityInterface
{
    /**
     * @var Registry
     */
    public $coreRegistry;
    public $product;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);

        $this->setTabTitle();
    }

    /**
     * Get current product
     *
     * @return null|int
     */
    public function getProduct()
    {
        if (!$this->product) {
            $this->product = $this->coreRegistry->registry('product');
        }
        return $this->product;
    }

    /**
     * Set tab title
     *
     * @return void
     */
    public function setTabTitle()
    {
        $this->setTitle(__('Electrical Specifications'));
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return ['lighting_tab'];
    }

    public function getLightAttributes()
    {
        return [
            'power_source',
            'color_temp',
            'cri',
            'led_life',
            'battery_life',
            'charging_time',
            'battery',
            'voltage',
            'number_of_bulbs',
            'bulb_type',
            'bulb_supplied',
            'max_wattage',
            'shade_included',
            'dimmable',
            'certifications'
        ];
    }

    public function getAttributeValue($attributeCode)
    {
        $product = $this->getProduct();
        $productAttribute = $this->getProductResource($product, $attributeCode);
        return $productAttribute->getFrontend()->getValue($product);
    }

    public function getAttributeLabel($attributeCode)
    {
        $product = $this->getProduct();
        $productAttribute = $this->getProductResource($product, $attributeCode);
        return $productAttribute->getStoreLabel();
    }

    public function getProductResource($product, $attributeCode)
    {
        return $product->getResource()->getAttribute($attributeCode);
    }

    public function checkTabDisplay()
    {
        $result = false;
        foreach ($this->getLightAttributes() as $value) {
            if($this->getAttributeValue($value)){
                $result = true;
                break;
            }
        }
        return $result;
    }
}
