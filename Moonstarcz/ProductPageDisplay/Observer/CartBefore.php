<?php
namespace Moonstarcz\ProductPageDisplay\Observer;


use Magento\Framework\App\RequestInterface;

class CartBefore implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        RequestInterface $request
    ) {
        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $classId = $this->request->getParam('class_id');
        $item = $observer->getData('quote_item');
        $item->setData('class_id', $classId);
    }
}
