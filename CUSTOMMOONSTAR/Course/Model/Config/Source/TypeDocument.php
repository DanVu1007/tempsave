<?php
namespace Moonstarcz\Course\Model\Config\Source;

class TypeDocument implements \Magento\Framework\Option\ArrayInterface
{
    const DOCX  =   0;
    const PDF   =   1;
    const RAR   =   2;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::DOCX,
                'label' => __('Docx')
            ],
            [
                'value' => self::PDF,
                'label' => __('Pdf')
            ],
            [
                'value' => self::RAR,
                'label' => __('Rar')
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
