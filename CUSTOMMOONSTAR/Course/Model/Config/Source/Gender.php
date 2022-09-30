<?php

namespace Moonstarcz\Course\Model\Config\Source;

class Gender implements \Magento\Framework\Option\ArrayInterface
{
    const FEMALE = 0;
    const MALE = 1;
    const NOT_SPECIFIED = 2;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::FEMALE,
                'label' => __('Female')
            ],
            [
                'value' => self::MALE,
                'label' => __('Male')
            ],
            [
                'value' => self::NOT_SPECIFIED,
                'label' => __('Not specified')
            ]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }
}
