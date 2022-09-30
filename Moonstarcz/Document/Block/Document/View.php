<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Moonstarcz\Document\Block\Document;

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Moonstarcz\Document\Model\Config\Source\Status;
use Moonstarcz\Document\Model\Document;
use Moonstarcz\Document\Model\DocumentFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class View extends Template
{
    const GG_DRIVE_URL = 'https://drive.google.com/uc?id=';
    const XML_DOCUMENT_WIDTH = 'document/view/width';
    const XML_DOCUMENT_HEIGHT = 'document/view/height';

    /**
     * @var DocumentFactory
     */
    private $documentFactory;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Context $context,
        DocumentFactory $documentFactory,
        ManagerInterface $messageManager,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        $this->documentFactory = $documentFactory;
        $this->messageManager = $messageManager;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * @return Document|null
     */
    public function getDocument()
    {
        $documentId = $this->getRequest()->getParam('id');
        $document = $this->documentFactory->create()->load($documentId);
        $document->getDriveFileId();
        if (!$document->getId() || $document->getStatus() == Status::DISABLE) {
            return null;
        }
        return $document;
    }

    public function getMediaUrl() {
        $mediaUrl = $this->getUrl('pub/media');
        $path = $this->getDocument()->getFilePath();
        return $mediaUrl . 'document' . $path;
    }

    public function getDriveFile() {
        $driveFileId = $this->getDocument()->getDriveFileId();
        return self::GG_DRIVE_URL . $driveFileId;
    }

    public function getBlockContent(Document $document)
    {
        if ($document->getType() == \Moonstarcz\Document\Model\Config\Source\TypeDocument::UPLOAD) {
            $this->setTemplate('Moonstarcz_Document::document/view/pdf.phtml');
        }
        if ($document->getType() == \Moonstarcz\Document\Model\Config\Source\TypeDocument::DRIVE_FILE_ID) {
            $this->setTemplate('Moonstarcz_Document::document/view/video.phtml');
        }
        return $this;
    }

    public function getDocumentWidth() {
        return $this->scopeConfig->getValue(self::XML_DOCUMENT_WIDTH, ScopeInterface::SCOPE_STORE);
    }

    public function getDocumentHeight() {
        return $this->scopeConfig->getValue(self::XML_DOCUMENT_HEIGHT, ScopeInterface::SCOPE_STORE);
    }
}
