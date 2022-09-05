<?php
namespace Moonstarcz\Course\Model\Config\Source;

class TypeDocument implements \Magento\Framework\Option\ArrayInterface
{
    const DOCX  =   'docx';
    const PDF   =   'pdf';
    const RAR   =   'rar';
    const JPG   =   'jpg';
    const JPEG  =   'jpeg';
    const PNG   =   'png';

    const TYPEOFDOCUMENTS = [
        self::DOCX,
        self::PDF,
        self::RAR,
        self::JPG,
        self::JPEG,
        self::PNG
    ];
    /**
     * @var array
     */
    protected $options;

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = [['label' => __('Please select'), 'value' => 0]];

            foreach (self::TYPEOFDOCUMENTS as $key => $value) {
                $this->options[] = [
                    'label' => ucfirst($value),
                    'value' => ($key+1)
                ];
            }
        }

        return $this->options;
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
