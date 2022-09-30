<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Moonstarcz\Course\Model\Moonstarczclass;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Moonstarcz\Course\Model\ResourceModel\MoonstarczClass\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @inheritDoc
     */
    protected $collection;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;


    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param ProductRepositoryInterface $productRepository
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        ProductRepositoryInterface $productRepository,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->productRepository = $productRepository;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();

            $productId = $model->getData('course_id');
            if ($productId) {
                $product = $this->productRepository->getById($productId);
                $this->loadedData[$model->getId()]['course_name'] = $product->getName();
            } else {
                return $this->loadedData;
            }
        }
        $data = $this->dataPersistor->get('moonstarcz_course_moonstarcz_class');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('moonstarcz_course_moonstarcz_class');
        }

        return $this->loadedData;
    }
}
