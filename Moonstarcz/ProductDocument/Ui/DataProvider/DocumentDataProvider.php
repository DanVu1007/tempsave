<?php

namespace Moonstarcz\ProductDocument\Ui\DataProvider;

use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Moonstarcz\Document\Model\Document;
use Moonstarcz\Document\Model\ResourceModel\Document\CollectionFactory;

class DocumentDataProvider extends AbstractDataProvider
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
        if ($filter->getField() == 'entity_id' && $filter->getConditionType() == 'nin') {
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
        $data->addFieldToFilter(Document::STATUS, self::STATUS_ENABLED);
        $data = $data->toArray();

        if ($this->totalRecordPlus) {
            $data['totalRecords'] += $this->totalRecordPlus;
        }

        return $data;
    }
}
