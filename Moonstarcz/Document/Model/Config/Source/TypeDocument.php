<?php


namespace Moonstarcz\Document\Model\Config\Source;



class TypeDocument implements \Magento\Framework\Option\ArrayInterface
{
    const UPLOAD = 0;
    const DRIVE_FILE_ID = 1;

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
                'value' => self::UPLOAD,
                'label' => __('Upload')
            ],
            [
                'value' => self::DRIVE_FILE_ID,
                'label' => __('Google Drive File')
            ],
        ];
    }
}

