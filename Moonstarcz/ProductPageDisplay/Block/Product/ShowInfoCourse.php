<?php

namespace Moonstarcz\ProductPageDisplay\Block\Product;

use Laminas\Validator\Date;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Moonstarcz\Course\Model\ResourceModel\MoonstarczClass\CollectionFactory;
use Moonstarcz\Course\Model\MoonstarczClassFactory;

class ShowInfoCourse extends Template
{
    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @var CollectionFactory
     */
    private $classCollectionFactory;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var MoonstarczClassFactory
     */
    private $classFactory;


    /**
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param CollectionFactory $classCollectionFactory
     * @param ResourceConnection $resourceConnection
     * @param StoreManagerInterface $storeManager
     * @param MoonstarczClassFactory $classFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        CollectionFactory $classCollectionFactory,
        ResourceConnection $resourceConnection,
        StoreManagerInterface $storeManager,
        MoonstarczClassFactory $classFactory,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->classCollectionFactory = $classCollectionFactory;
        $this->resourceConnection = $resourceConnection;
        $this->storeManager = $storeManager;
        $this->classFactory = $classFactory;
        parent::__construct($context, $data);
    }

    public function getNearestClass()
    {
        $productId = $this->getRequest()->getParam('id');
        $selectedClasses = $this->getClassesByCourseId($productId);
        return $selectedClasses->getFirstItem();
    }

    public function getClassesByCourseId($courseId)
    {
        $classCollection = $this->classCollectionFactory->create();
        $collection = $classCollection->addFieldToFilter('course_id', ['eq' => $courseId]);
        $collection->setOrder('start_date', 'asc');
        return $collection;
    }

    public function displayDate()
    {
        $result = null;
        $nearestClass = $this->getNearestClass();
        $startDate = $nearestClass->getStartDate();
        $endDate = $nearestClass->getEndDate();
        if ($nearestClass && $startDate && $endDate) {
            $result = $this->reformDate($startDate) . ' - ' . $this->reformDate($endDate);
        }
        return $result;
    }

    public function displayTime()
    {
        $result = [];
        $nearestClass = $this->getNearestClass();
        if ($nearestClass) {
            $result = [
                'total_lesson' => $nearestClass->getTotalLesson(),
                'lesson_time' => $nearestClass->getLessonTime()
            ];
        }
        return $result;
    }

    public function reformDate($date)
    {
        return date('d/m/Y',strtotime($date));
    }

    public function getClassSelection()
    {
        $productId = $this->getRequest()->getParam('id');
        $classes = $this->getClassesByCourseId($productId);

        if ($classes) {
            $result = [];
            foreach ($classes as $class) {
                $numberOfStudentInClass = $this->countClassId($class->getEntityId());
                $statusClass = $this->statusClass($numberOfStudentInClass, $class->getMaxStudent());
                $result [] = [
                    'show_class_time' => $this->showClassTime($class),
                    'status_class' => $statusClass,
                    'value' =>  $class->getEntityId(),
                    'number_of_student' => $numberOfStudentInClass,
                    'max_student' => $class->getMaxStudent()
                ];
            }
        } else {
            $result = null;
        }
        return $result;
    }

    public function showClassTime($class)
    {
        return $class->getStartTime() . ' - ' . $class->getEndTime();
    }

    public function countClassId($classId)
    {
        $class = $this->classFactory->create()->load($classId);
        return $class->getListCustomerRegistered();
    }

    public function statusClass($studentNumber, $slotNumber)
    {
        $statusClass = 'full0';

        $result = (float)$studentNumber/$slotNumber;
        if ($result > 0.75){
            $statusClass = 'full75';
        }
        if ($result >= 1){
            $statusClass = 'full100';
        }
        if ($studentNumber == 0) {
            $statusClass = 'full0';
        }
        return $statusClass;
    }
}
