<?php


namespace Moonstarcz\Document\Model\File;


use Magento\Backend\Model\Session;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;

class FileUploader
{
    const PATH_PREFIX = 'document';
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Repository
     */
    private $assetRepo;

    /**
     * FileUploader constructor.
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Session $session
     * @param Repository $assetRepo
     * @param Registry $registry
     * @throws FileSystemException
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        Session $session,
        Repository $assetRepo,
        Registry $registry
    )
    {
        $this->session = $session;
        $this->registry = $registry;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(
            DirectoryList::MEDIA
        );
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
    }

    /**
     * @return array|string[]
     */
    public function uploadFile()
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => 'file']);
            $uploader->setAllowedExtensions($this->getExtension());

            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $result = $uploader->save(
                $this->mediaDirectory->getAbsolutePath(self::PATH_PREFIX)
            );
            unset($result['path']);

            if (!$result) {
                throw new LocalizedException(
                    __('File can not be saved to the destination folder.')
                );
            }
            $imageUrl = $this->getImageUrl($result['file']);
            $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
            $result['url'] = $imageUrl;
            $result['name'] = $result['file'];

            /** @codingStandardsIgnoreStart */
            $result['filename'] = pathinfo($result['name'], PATHINFO_FILENAME);
            $result['file_extension'] = pathinfo($result['name'], PATHINFO_EXTENSION);
            /** @codingStandardsIgnoreEnd */
            $result['previewUrl'] = $this->getPreViewUrl($result);
            $this->setResultCookie($result);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $result;
    }

    /**
     * @return string[]
     */
    private function getExtension()
    {
        return [
            'doc', 'docx', 'txt', 'rtf', 'pdf', 'djvu', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'mp4', 'mp3', 'zip', 'rar', '7z', 'csv', 'xls', 'xlsx', 'pptx', 'pptm', 'ppt'
        ];
    }

    /**
     * @param array|string[] $result
     */
    private function setResultCookie(&$result)
    {
        $result['cookie'] = [
            'name' => $this->session->getName(),
            'value' => $this->session->getSessionId(),
            'lifetime' => $this->session->getCookieLifetime(),
            'path' => $this->session->getCookiePath(),
            'domain' => $this->session->getCookieDomain(),
        ];
    }

    /**
     * @param $path
     * @param $fileName
     *
     * @return string
     */
    public function getFilePath($path, $fileName)
    {
        return rtrim($path, '/') . '/' . ltrim($fileName, '/');
    }

    public function getPreViewUrl($result)
    {
        $extension = $result['file_extension'];
        if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
            return $this->getImageUrl($result['file']);
        } else {
            $path = 'Moonstarcz_Document::images/' . $extension . '.png';
            return $this->assetRepo->getUrl($path);
        }
    }

    public function getImageUrl($filePath)
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB) . 'media/'
            . $this->getFilePath(self::PATH_PREFIX, $filePath);
    }
}
