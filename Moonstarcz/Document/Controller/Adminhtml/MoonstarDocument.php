<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */


namespace Moonstarcz\Document\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;

abstract class MoonstarDocument extends Action
{

    protected $_coreRegistry;
    const ADMIN_RESOURCE = 'Moonstarcz_Course::top_level';

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Moonstar'), __('Moonstar'))
            ->addBreadcrumb(__('Moonstar Document'), __('Moonstar Document'));
        return $resultPage;
    }
}
