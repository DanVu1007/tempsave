<?php
namespace Moonstarcz\Course\Model\Config\Source;

use Moonstarcz\Course\Model\ResourceModel\MoonstarczTeacher\CollectionFactory;

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
     * @param CollectionFactory $teacherCollectionFactory
     * @param void
     */
    public function __construct(
        CollectionFactory $teacherCollectionFactory
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
