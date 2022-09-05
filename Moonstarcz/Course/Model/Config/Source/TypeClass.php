<?php
namespace Moonstarcz\Course\Model\Config\Source;

class TypeClass implements \Magento\Framework\Option\ArrayInterface
{
    const OFFLINE   =   0;
    const ONLINE    =   1;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::ONLINE,
                'label' => __('Học Online')
            ],
            [
                'value' => self::OFFLINE,
                'label' => __('Học Offline')
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
