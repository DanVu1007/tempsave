<?php


namespace Moonstarcz\GoogleDrive\Api;

use Google\Service\Drive;

interface FileInterface
{
    /**
     * Get File Information
     *
     * @param string $fileId
     * @return Drive\DriveFile
     * @throws \Exception
     */
    public function getFile($fileId);
}
