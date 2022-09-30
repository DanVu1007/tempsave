<?php

namespace Moonstarcz\ProductDocument\Model\Product\DataProvider\Modifiers;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Moonstarcz\Document\Model\Document;
use Moonstarcz\ProductDocument\Model\ResourceModel\DocumentStoreProduct;

class Data
{
    const DOCUMENT_FIELDS = [
        Document::NAME,
        Document::STATUS,
        Document::TYPE,
        Document::FILE_NAME,
        Document::EXTENSION
    ];

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var DocumentStoreProduct
     */
    private $documentStoreProductResource;

    /**
     * Data constructor.
     * @param LocatorInterface $locator
     * @param DocumentStoreProduct $documentStoreProductResource
     */
    public function __construct(
        LocatorInterface $locator,
        DocumentStoreProduct $documentStoreProductResource
    ) {
        $this->documentStoreProductResource = $documentStoreProductResource;
        $this->locator = $locator;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function execute(array $data)
    {
        $data[$this->locator->getProduct()->getId()]['fieldset_documents']['documents'] = $this->getDocument();
        return $data;
    }

    /**
     * @return array
     */
    private function getDocument()
    {
        $productId = $this->locator->getProduct()->getId();
        $result = [];
        if ($productId) {
            try {
                $documentStoreProducts = $this->documentStoreProductResource->getDocumentIdsByProductId($productId);
                if (!empty($documentStoreProducts)) {
                    foreach ($documentStoreProducts as $item) {
                        if (!empty($result[$item['entity_id']])) {
                            continue;
                        }
                        $row = [];
                        $row['entity_id'] = $row['entity_id'] = $item['entity_id'];

                        foreach (self::DOCUMENT_FIELDS as $field) {
                                $row[$field] = $item[$field];
                        }

                        $result[$row['entity_id']] = $row;
                    }
                }
            } catch (\Exception $e) {
                return  [];
            }
        }

        return array_merge($result);
    }
}
