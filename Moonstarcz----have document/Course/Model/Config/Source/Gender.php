<?php
namespace Moonstarcz\Course\Model\Config\Source;

class Gender implements \Magento\Framework\Option\ArrayInterface
{
    const MALE              =   'male';
    const FEMALE            =   'female';
    const NOT_SPECIFIED     =   'not_specified';

    const TYPEOFDOCUMENTS = [
        self::MALE,
        self::FEMALE,
        self::NOT_SPECIFIED
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
