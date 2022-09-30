<?php

namespace Moonstarcz\Document\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Moonstarcz\Document\Api\DocumentInterface;

class Document extends AbstractModel implements DocumentInterface
{
    const CACHE_TAG = 'moonstarcz_Document_moonstarcz_document';
    const STATUS = 'status';
    const TYPE = 'type';
    const NAME = 'name';
    const FILE_NAME = 'filename';
    const EXTENSION = 'extension';
    const FILE_PATH = 'file_path';
    const GG_FILE_ID = 'gg_file_id';
    const DESCRIPTION = 'description';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'moonstar_document';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource $resource
     * @param AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Moonstarcz\Document\Model\ResourceModel\Document');
    }

    /**
     * Return a unique id for the model.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param $status
     * @return Document
     */
    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @param $type
     * @return Document
     */
    public function setType($type)
    {
        $this->setData(self::TYPE, $type);
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param $name
     * @return Document
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->getData(self::FILE_NAME);
    }

    /**
     * @param $fileName
     * @return Document
     */
    public function setFileName($fileName)
    {
        $this->setData(self::FILE_NAME, $fileName);
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->getData(self::EXTENSION);
    }

    /**
     * @param $extension
     * @return Document
     */
    public function setExtension($extension)
    {
        $this->setData(self::EXTENSION, $extension);
        return $this;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->getData(self::FILE_PATH);
    }

    /**
     * @param $filePath
     * @return Document
     */
    public function setFilePath($filePath)
    {
        $this->setData(self::FILE_PATH, $filePath);
        return $this;
    }

    /**
     * @return string
     */
    public function getDriveFileId()
    {
        return $this->getData(self::GG_FILE_ID);
    }

    /**
     * @param $driveFileId
     * @return Document
     */
    public function setDriveFileId($driveFileId)
    {
        $this->setData(self::GG_FILE_ID, $driveFileId);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @param $description
     * @return mixed
     */
    public function setDescription($description)
    {
        $this->setData(self::DESCRIPTION, $description);
        return $this;
    }
}
