<?php


namespace Moonstarcz\Document\Block\Course;

use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Moonstarcz\Document\Helper\Data;

class ListCourse extends Template
{
    const COURSE_IMAGE_ID = 'category_page_list';
    /**
     * @var Data
     */
    public $helperData;
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    public $orderCollectionFactory;
    /**
     * @var CollectionFactory
     */
    public $productCollectionFactory;
    /**
     * @var ImageBuilder
     */
    public $imageBuilder;

    public function __construct(
        Template\Context $context,
        Data $helperData,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        CollectionFactory $productCollectionFactory,
        ImageBuilder $imageBuilder,
        array $data = []
    )
    {
        $this->helperData = $helperData;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->imageBuilder = $imageBuilder;
        parent::__construct($context, $data);
    }


    public function getAllProductIdsOrdered()
    {
        $productIds = [];
        $customer = $this->helperData->getCustomerLoggedId();
        $orderCollection = $this->orderCollectionFactory->create();
        $orderCollection->addFieldToFilter('customer_id', $customer->getId());
        foreach ($orderCollection as $order) {
            $orderItems = $order->getItems();
            foreach ($orderItems as $item) {
                $productIds[] = $item->getProductId();
            }
        }
        return $productIds;
    }

    public function getCourses()
    {
        $productIdsOrdered = $this->getAllProductIdsOrdered();
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect(['name', 'short_description', 'small_image']);
        $productCollection->addIdFilter($productIdsOrdered);
        return $productCollection;
    }

    public function getViewDocumentUrl($courseId)
    {
        return $this->getUrl('moonstar/course/view', ['id' => $courseId]);
    }

    public function getCourseImage($course, $imageId = self::COURSE_IMAGE_ID, $attributes = [])
    {
        return $this->imageBuilder->create($course, $imageId, $attributes);
    }
}
