<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Moonstarcz\Course\Controller\Adminhtml\Classroom;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @var \Moonstarcz\Course\Model\MoonstarczClassFactory
     */
    private $moonstarczClass;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Moonstarcz\Course\Model\MoonstarczClassFactory $moonstarczClass
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->moonstarczClass = $moonstarczClass;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            $this->validateDateTime($data);

            $model = $this->moonstarczClass->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Moonstarcz Class no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);
            try {
                // SAVE
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Moonstarcz Class.'));
                $this->dataPersistor->clear('moonstarcz_course_moonstarcz_class');
                //SAVE AND NEW
                if ($this->getRequest()->getParam('back') == "save_and_new") {
                    return $resultRedirect->setPath('*/*/newaction');
                }
                //DUPLICATE
                if ($this->getRequest()->getParam('back') == "duplicate") {
                    $duplicated_model = $this->duplicate($model);
                    $duplicated_model->save();
                    $this->messageManager->addSuccessMessage(__('You saved the Moonstarcz Duplicate Class.'));
                    $this->dataPersistor->clear('moonstarcz_course_moonstarcz_class');
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $duplicated_model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Moonstarcz Class.'));
            }

            $this->dataPersistor->set('moonstarcz_course_moonstarcz_class', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }


    public function duplicate($model)
    {
        $model_duplicate = $this->moonstarczClass;
        $newData = $model->getData();

        unset($newData['entity_id']);
        $newData['status'] = 0;
        $newData['name'] = $newData['name'] . '-1';
        $model_duplicate->setData($newData);
        return $model_duplicate;
    }

    public function validateDateTime($data)
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        
        //Validate class form
        $dateNotRight = false;
        $timeNotRight = false;
        $message = [];

        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $startTime = $data['start_time'];
        $endTime = $data['end_time'];

        //DATE
        $arrStartDate = explode('/', $startDate);
        $arrEndDate = explode('/', $endDate);

        if (!($arrEndDate[2] >= $arrStartDate[2] && $arrEndDate[1] >= $arrStartDate[1] && $arrEndDate[1] >= $arrStartDate[1])) {
            $dateNotRight = true;
            $message[] = "Start date must be greater than end date";
        }

        //TIME
        $extendStartTime    = explode(' ', $startTime);
        $arrStartTime       = explode(':', $extendStartTime[0]);
        $extendEndTime      = explode(' ', $endTime);
        $arrEndTime         = explode(':', $extendEndTime[0]);

        if ($extendStartTime[1] == 'pm' && $extendEndTime[1] == 'am') {
            $timeNotRight = true;
            $message[] = "End time must be greater than start time";
        } else if (
            ($extendStartTime[1] == $extendEndTime[1]) &&
            ($arrStartTime[0] > $arrEndTime[0])
        ) {
            $timeNotRight = true;
            $message[] = "End time must be greater than start time";
        }

        //SET MESSAGE
        if ($dateNotRight || $timeNotRight) {
            foreach ($message as $value) {
                $this->messageManager->addErrorMessage(__($value));
            }
            return $resultRedirect->setPath('*/*/');
        }
    }
}
