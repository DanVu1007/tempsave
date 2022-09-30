<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Moonstarcz\Course\Controller\Adminhtml\Classroom;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Moonstarcz\Course\Model\MoonstarczClassFactory;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;

    /**
     * @var MoonstarczClassFactory
     */
    private $moonstarczClass;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param MoonstarczClassFactory $moonstarczClass
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        MoonstarczClassFactory $moonstarczClass
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->moonstarczClass = $moonstarczClass;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            $model = $this->moonstarczClass->create();
            $model->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Moonstar Class no longer exists.'));
                return $resultRedirect->setPath('moonstarcz/classroom/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Moonstar Class.'));
                $this->dataPersistor->clear('moonstarcz_course_moonstarcz_class');

                $actionBtn = $this->getRequest()->getParam('back');
                //SAVE AND NEW
                if ($actionBtn == "save_and_new") {
                    return $resultRedirect->setPath('moonstarcz/classroom/newaction');
                }
                //DUPLICATE
                if ($actionBtn == "duplicate") {
                    $duplicated_model = $this->duplicateModel($model);
                    $duplicated_model->save();
                    $this->messageManager->addSuccessMessage(__('You saved the Moonstar Duplicate Class.'));
                    $this->dataPersistor->clear('moonstarcz_course_moonstarcz_class');
                    return $resultRedirect->setPath('moonstarcz/classroom/edit', ['entity_id' => $duplicated_model->getId()]);
                }
                return $resultRedirect->setPath('moonstarcz/classroom/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Moonstar Class.'));
            }

            $this->dataPersistor->set('moonstarcz_course_moonstarcz_class', $data);
            return $resultRedirect->setPath('moonstarcz/classroom/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('moonstarcz/classroom/');
    }

    public function duplicateModel($model)
    {
        $model_duplicate = $this->moonstarczClass->create();
        $newData = $model->getData();

        unset($newData['entity_id']);
        $newData['status'] = 0;
        $newData['name'] = $newData['name'] . '-1';
        $model_duplicate->setData($newData);
        return $model_duplicate;
    }
}
