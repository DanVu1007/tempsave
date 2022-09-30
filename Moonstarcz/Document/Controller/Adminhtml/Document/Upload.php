<?php


namespace Moonstarcz\Document\Controller\Adminhtml\Document;


use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action;

use Moonstarcz\Document\Model\File\FileUploader;

/**
 * Class Upload
 * @package OpenTechiz\ProductAttachment\Controller\Adminhtml\File\Uploader
 */
class Upload extends Action
{
    /**
     * @var FileUploader
     */
    protected $fileUploader;

    /**
     * Upload constructor.
     *
     * @param Context $context
     * @param FileUploader $fileUploader
     */
    public function __construct(
        Context $context,
        FileUploader $fileUploader
    ) {
        $this->fileUploader = $fileUploader;
        parent::__construct($context);
    }

    /**
     * Upload file controller action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $resultJson->setData($this->fileUploader->uploadFile());
    }

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Moonstarcz_Document::files_list';
}
