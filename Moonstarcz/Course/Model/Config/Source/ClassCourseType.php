<?php

namespace Moonstarcz\Course\Model\Config\Source;

class ClassCourseType extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    const SOLO  =   0;
    const DUO   =   1;
    const TRIO  =   2;
    const GROUP =   3;
    
    /**
     * Options getter
     * 
     * @return array
     */
    public function getAllOptions()
    {
        return [
            [
                'value' => self::SOLO,
                'label' => __('1 kèm 1 SOLO')
            ],
            [
                'value' => self::DUO,
                'label' => __('1 kèm 2 DUO')
            ],
            [
                'value' => self::TRIO,
                'label' => __('1 kèm 3 TRIO')
            ],
            [
                'value' => self::GROUP,
                'label' => __('NHÓM 4-8 học viên')
            ]
        ];
    }
}
