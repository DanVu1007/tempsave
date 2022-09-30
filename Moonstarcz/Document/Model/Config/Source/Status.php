<?php


namespace Moonstarcz\Document\Model\Config\Source;



class Status implements \Magento\Framework\Option\ArrayInterface
{
    const ENABLE = 1;
    const DISABLE = 0;

    protected $options;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::ENABLE,
                'label' => __('Enable')
            ],
            [
                'value' => self::DISABLE,
                'label' => __('Disable')
            ],
        ];
    }
}
