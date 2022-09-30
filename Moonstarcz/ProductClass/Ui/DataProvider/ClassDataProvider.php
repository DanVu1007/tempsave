<?php

namespace Moonstarcz\ProductClass\Ui\DataProvider;

use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Moonstarcz\ProductClass\Api\Data\ClassInterface;
use Moonstarcz\Course\Model\ResourceModel\MoonstarczClass\CollectionFactory;

class ClassDataProvider extends AbstractDataProvider
{
    const STATUS_ENABLED = 1;

    /**
     * @inheritDoc
     */
    protected $collection;

    /**
     * @var int
     */
    private $totalRecordPlus;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function addFilter(Filter $filter)
    {
        if ($filter->getField() == ClassInterface::ENTITY_ID && $filter->getConditionType() == 'nin') {
            if ($filter->getValue()) {
                $this->totalRecordPlus = count($filter->getValue());
            }
        }
        parent::addFilter($filter);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data = $this->getCollection();
        $data->addFieldToFilter(ClassInterface::STATUS, self::STATUS_ENABLED);
        $data->addFieldToFilter('course_id', 0);
        $data = $data->toArray();

        if ($this->totalRecordPlus) {
            $data['totalRecords'] += $this->totalRecordPlus;
        }

        return $data;
    }
}
