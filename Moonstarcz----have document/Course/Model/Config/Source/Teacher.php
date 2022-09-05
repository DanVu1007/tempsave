<?php
namespace Moonstarcz\Course\Model\Config\Source;

class Teacher implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var Moonstarcz\Course\Model\ResourceModel\MoonstarczTeacher\CollectionFactory
     */
    private $teacherCollectionFactory;

    /**
     * Initialize dependencies.
     *
     * @param \Moonstarcz\Course\Model\ResourceModel\MoonstarczTeacher\CollectionFactory $teacherCollectionFactory
     * @param void
     */
    public function __construct(
        \Moonstarcz\Course\Model\ResourceModel\MoonstarczTeacher\CollectionFactory $teacherCollectionFactory
    ) {
        $this->teacherCollectionFactory = $teacherCollectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = [['label' => __('Please select'), 'value' => 0]];
            $collection = $this->teacherCollectionFactory->create();

            foreach ($collection as $item) {
                $this->options[] = [
                    'label' => $item->getName(),
                    'value' => $item->getEntity_id(),
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
