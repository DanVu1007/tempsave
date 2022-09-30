<?php


namespace Moonstarcz\GoogleDrive\Model;

use Google\Client;
use Google\Service\Drive;
use Moonstarcz\GoogleDrive\Helper\Data;

class FileManagement implements \Moonstarcz\GoogleDrive\Api\FileInterface
{
    const FILE_CONFIG = [
        ['alt' => 'media']
    ];
    public $drive;
    public $client;
    /**
     * @var Data
     */
    private $helperData;

    public function __construct(
        Data $helperData
    )
    {
        $this->helperData = $helperData;
    }

    private function _initialization()
    {
        if (!$this->drive) {
            $authConfigPath = $this->helperData->getServiceAccountKeyFilePath();
            $client = new Client();
            $client->setAuthConfig($authConfigPath);
            $client->useApplicationDefaultCredentials();
            $client->addScope(Drive::DRIVE);
            $this->drive = new Drive($client);
        }
    }

    /**
     * @param $fileId
     * @return Drive\DriveFile
     * @throws \Exception
     */
    public function getFile($fileId)
    {
        $optParams = [
            'fields' => '*'
        ];
        $driveService = $this->getDrive();
        if (!$driveService) {
            throw new \Exception('Google Drive has not been initialized.');
        }
        try {
            $file = $driveService->files->get($fileId, $optParams);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $file;
    }

    private function getDrive()
    {
        $this->_initialization();
        return $this->drive;
    }
}
