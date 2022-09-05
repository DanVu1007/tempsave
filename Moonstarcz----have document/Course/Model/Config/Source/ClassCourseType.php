<?php

namespace Moonstarcz\Course\Model\Config\Source;

class ClassCourseType extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    const SOLO  =   '1 kèm 1 SOLO';
    const DUO   =   '1 kèm 2 DUO';
    const TRIO  =   '1 kèm 3 TRIO';
    const GROUP =   'NHÓM 4-8 học viên';

    const TYPEOFDOCUMENTS = [
        self::SOLO,
        self::DUO,
        self::TRIO,
        self::GROUP
    ];
    
    public function getAllOptions()
    {
        $options = self::TYPEOFDOCUMENTS;
        $arrayUse = [];

        $arrayValue = [];
        foreach ($options as $key => $value) {
            $arrayValue['value'] = $key;
            $arrayValue['label'] = __($value);
            array_push($arrayUse, $arrayValue);
        }

        return $arrayUse;
    }
}