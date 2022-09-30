<?php
namespace Moonstarcz\ProductPageDisplay\Plugin\Model\Quote;

use Magento\Catalog\Model\Product\Type\AbstractType;
use Moonstarcz\Course\Model\MoonstarczClassFactory;

class Plugin
{
    /**
     * @var MoonstarczClassFactory
     */
    private $moonstarczClassFactory;

    public function __construct(
        MoonstarczClassFactory $moonstarczClassFactory
    )

    {
        $this->moonstarczClassFactory = $moonstarczClassFactory;

    }
    public function aroundAddProduct(
        \Magento\Quote\Model\Quote $subject, \Closure $proceed,
        \Magento\Catalog\Model\Product $product,
        $request,
        $processMode = AbstractType::PROCESS_MODE_FULL
    )
    {
        //Check user must choice a class
        $classId = $request->getClassId();
        if(!$classId) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('You must choice a class.')
            );
        }

        //Check slot in class
        $moonstarczClass = $this->moonstarczClassFactory->create();
        $maxStudent = $moonstarczClass->load($classId)->getMaxStudent();
        $countRegisteredStudents = $moonstarczClass->getListCustomerRegistered($classId);
        if($countRegisteredStudents >= $maxStudent) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('This class has no slot.')
            );
        }

        return $proceed($product,$request,$processMode);
    }
}
