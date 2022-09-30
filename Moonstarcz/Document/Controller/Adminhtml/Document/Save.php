<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Moonstarcz\Document\Controller\Adminhtml\Document;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Moonstarcz\Document\Model\Config\Source\TypeDocument;
use Moonstarcz\Document\Model\DocumentFactory as DocumentFactory;

class Save extends Action
{

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var DocumentFactory
     */
    private $documentFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param DocumentFactory $documentFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        DocumentFactory $documentFactory
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->documentFactory = $documentFactory;
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
        $params = $this->getRequest()->getParams();

        if ($params) {
            $data = $this->prepareDocumentData($params);
            $model = $this->documentFactory->create();
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Document.'));
                $this->dataPersistor->clear('moonstarcz_Document_moonstarcz_document');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Document.'));
            }

            $this->dataPersistor->set('moonstarcz_Document_moonstarcz_document', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function prepareDocumentData($params)
    {
        $data = [
            'status' => $params['status'],
            'type' => $params['type'],
            'filename' => $params['filename'],
            'extension' => $params['extension'],
            'name' => $params['name'],
            'description' => $params['description'],
            'file_path' => $params['type'] == TypeDocument::UPLOAD ? $this->getFilePath($params['file']) : '',
            'gg_file_id' => $params['type'] == TypeDocument::DRIVE_FILE_ID ? $params['gg_file_id'] : '',
        ];
        if ($params['entity_id']) {
            $data['entity_id'] = $params['entity_id'];
        }
        return $data;
    }

    private function getFilePath($files)
    {
        $filePath = '';
        foreach ($files as $file) {
            $filePath = $file['file'];
            break;
        }
        return $filePath;
    }
}
