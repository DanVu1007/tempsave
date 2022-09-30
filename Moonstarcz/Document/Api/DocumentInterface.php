<?php


namespace Moonstarcz\Document\Api;
use  Moonstarcz\Document\Model\Document;

interface DocumentInterface
{
    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param $status
     * @return Document
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param $type
     * @return Document
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     * @return Document
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getFileName();

    /**
     * @param $fileName
     * @return Document
     */
    public function setFileName($fileName);

    /**
     * @return string
     */
    public function getExtension();

    /**
     * @param $extension
     * @return Document
     */
    public function setExtension($extension);

    /**
     * @return string
     */
    public function getFilePath();

    /**
     * @param $filePath
     * @return Document
     */
    public function setFilePath($filePath);

    /**
     * @return string
     */
    public function getDriveFileId();

    /**
     * @param $driveFileId
     * @return Document
     */
    public function setDriveFileId($driveFileId);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param $description
     * @return Document
     */
    public function setDescription($description);


}
