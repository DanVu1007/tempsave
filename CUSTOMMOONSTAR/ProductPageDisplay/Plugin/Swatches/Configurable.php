<?php
namespace Moonstarcz\ProductPageDisplay\Plugin\Swatches;

class Configurable
{
    public function afterGetJsonConfig(\Magento\Swatches\Block\Product\Renderer\Configurable $subject, $result) {
        $jsonResult = json_decode($result, true);
        foreach ($subject->getAllowProducts() as $simpleProduct) {
            $id = $simpleProduct->getId();
            foreach($simpleProduct->getAttributes() as $attribute) {
                if(($attribute->getIsVisible() && $attribute->getIsVisibleOnFront()) || in_array($attribute->getAttributeCode(), ['coures_type']) ) {
                    $code = $attribute->getAttributeCode();
                    $value = (string)$attribute->getFrontend()->getValue($simpleProduct);
                    $jsonResult['dynamic'][$code][$id] = [
                        'value' => $value
                    ];
                }
            }
        }
        $result = json_encode($jsonResult);
        return $result;
    }
}

