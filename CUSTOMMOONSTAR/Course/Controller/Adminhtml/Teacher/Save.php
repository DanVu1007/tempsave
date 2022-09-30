<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Moonstarcz\Course\Controller\Adminhtml\Teacher;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Moonstarcz\Course\Model\Moonstarczteacher\ImageUploader;
use Moonstarcz\Course\Model\MoonstarczTeacherFactory;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;

    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * @var MoonstarczTeacherFactory
     */
    private $moonstarczTeacher;

    /**
     * @param Context $context
     * @param ImageUploader $imageUploader
     * @param DataPersistorInterface $dataPersistor
     * @param MoonstarczTeacherFactory $moonstarczTeacher
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        DataPersistorInterface $dataPersistor,
        MoonstarczTeacherFactory $moonstarczTeacher
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->moonstarczTeacher = $moonstarczTeacher;
        $this->imageUploader = $imageUploader;

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

            $model = $this->moonstarczTeacher->create();
            $model->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Teacher no longer exists.'));
                return $resultRedirect->setPath('moonstarcz/teacher/');
            }

            $data2 = $data;
            if (isset($data2['image'][0]['name'])) {
                $data2['images'] = $data['image'][0]['name'];
                $imageName = $data2['images'];
            } else {
                $imageName = '';
            }
            $data['image'] = $imageName;
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Teacher.'));
                $this->dataPersistor->clear('moonstarcz_course_moonstarcz_teacher');
                if ($imageName) {
                    $this->imageUploader->moveFileFromTmp($imageName);
                }
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('moonstarcz/teacher/edit', ['entity_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('moonstarcz/teacher/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Teacher.'));
            }

            $this->dataPersistor->set('moonstarcz_course_moonstarcz_teacher', $data);
            return $resultRedirect->setPath('moonstarcz/teacher/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('moonstarcz/teacher/');
    }
}
