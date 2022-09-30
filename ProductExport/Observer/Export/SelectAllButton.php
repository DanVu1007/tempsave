<?php


namespace OmnyfyCustomzation\ProductExport\Observer\Export;


use Magento\Backend\Block\Widget\Grid;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SelectAllButton implements ObserverInterface
{
    /**
     * Apply select all button
     *
     * @param Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Backend\Block\Widget\Grid $grid */
        $grid = $observer->getEvent()->getData('grid');
        if ($grid instanceof Grid && $grid->getId() == 'export_filter_grid') {
            $grid->setChild(
                'select_all_button',
                $grid->getLayout()->createBlock(
                    \Magento\Backend\Block\Widget\Button::class
                )->setData(
                    [
                        'label' => __('Select All'),
                        'onclick' => $grid->getJsObjectName() . '.selectAll()',
                        'class' => 'action-selectall select action-tertiary'
                    ]
                )->setDataAttribute(['action' => 'grid-select-all'])
            );
        }
    }
}