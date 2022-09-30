<?php

namespace Moonstarcz\ProductPageDisplay\Block\Product;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Moonstarcz\Course\Model\ResourceModel\MoonstarczClass\CollectionFactory;
use Moonstarcz\Course\Model\MoonstarczClassFactory;
use Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable;

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
     * @var Configurable
     */
    private $configurable;


    /**
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param CollectionFactory $classCollectionFactory
     * @param ResourceConnection $resourceConnection
     * @param StoreManagerInterface $storeManager
     * @param MoonstarczClassFactory $classFactory
     * @param Configurable $configurable
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        CollectionFactory $classCollectionFactory,
        ResourceConnection $resourceConnection,
        StoreManagerInterface $storeManager,
        MoonstarczClassFactory $classFactory,
        Configurable $configurable,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->classCollectionFactory = $classCollectionFactory;
        $this->resourceConnection = $resourceConnection;
        $this->storeManager = $storeManager;
        $this->classFactory = $classFactory;
        $this->configurable = $configurable;
        parent::__construct($context, $data);
    }

    public function getNearestClass()
    {
        $productId = $this->getRequest()->getParam('id');
        $selectedClasses = $this->getClassesByCourseId($productId);
        return $selectedClasses->getFirstItem();
    }

    public function getClassesByCourseId($courseIds)
    {
        $classCollection = $this->classCollectionFactory->create();
        $collection = $classCollection->addFieldToFilter('course_id', ['in' => $courseIds]);
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
        $childrenIds = $productId;
        $typeCourse = false;

        if($this->productFactory->create()->load($productId)->getTypeId() == 'configurable') {
            $childrenIds = array_values($this->configurable->getChildrenIds($productId)[0]);
            $typeCourse = true;
        }

        $classes = $this->getClassesByCourseId($childrenIds);

        if ($classes) {
            $result = [];
            foreach ($classes as $class) {
                $numberOfStudentInClass = $this->countClassId($class->getEntityId());
                $statusClass = $this->statusClass($numberOfStudentInClass, $class->getMaxStudent());
                $result ['class_info'][] = [
                    'show_class_time' => $this->showClassTime($class),
                    'status_class' => $statusClass,
                    'value' =>  $class->getEntityId(),
                    'number_of_student' => $numberOfStudentInClass,
                    'max_student' => $class->getMaxStudent(),
                    'type_class' =>$this->getTypeClass($class->getTypeClass()),
                ];
            }
        } else {
            $result = null;
        }
        $result['type_course'] = $typeCourse;
        return $result;
    }

    public function getTypeClass($typeClass)
    {
        $result = '';
        if($typeClass == (\Moonstarcz\Course\Model\Config\Source\TypeClass::OFFLINE)){
            $result = 'offline-class';
        }
        if($typeClass == (\Moonstarcz\Course\Model\Config\Source\TypeClass::ONLINE)){
            $result = 'online-class';
        }
        return $result;
    }

    public function showClassTime($class)
    {
        return $this->reformTime($class->getStartTime()) . ' - ' . $this->reformTime($class->getEndTime());
    }

    public function reformTime($time)
    {
        if(strpos($time, 'am') || strpos($time, 'pm')) {
            $time = explode(' ',$time);
            if($time[1]) {
                $arrTime = explode(':', $time[0]);
                $hour = '';
                if($time[1] == 'pm') {
                    $hour = $arrTime[0] + 12;
                }
                if($time[1] == 'am') {
                    $hour = $arrTime[0];
                }
                return $hour.':'.$arrTime[1];
            }
        }
        return $time;
    }

    public function countClassId($classId)
    {
        $class = $this->classFactory->create()->load($classId);
        return $class->getListCustomerRegistered($classId);
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
