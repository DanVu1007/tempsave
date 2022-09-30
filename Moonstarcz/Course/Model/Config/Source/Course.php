<?php
namespace Moonstarcz\Course\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Course implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
      * Initialize dependencies.
      *
      * @param CollectionFactory $productCollectionFactory
      * @param void
      */
    public function __construct(
        CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
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
            $collection = $this->productCollectionFactory->create();

            foreach ($collection as $item) {
                $this->options[] = [
                    'label' => $item->getSku(),
                    'value' => $item->getId(),
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
