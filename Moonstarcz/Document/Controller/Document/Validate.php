<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Moonstarcz\Document\Controller\Document;

use Exception;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\Response\HttpInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Result\PageFactory;
use Moonstarcz\Document\Helper\Data;
use Moonstarcz\GoogleDrive\Api\FileInterface;

class Validate implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var Json
     */
    protected $serializer;

    /**
     * @var Http
     */
    protected $http;
    /**
     * @var FileInterface
     */
    private $fileInterface;
    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     * @param RequestInterface $request
     * @param Json $json
     * @param FileInterface $fileInterface
     * @param Http $http
     * @param Data $helperData
     */
    public function __construct(
        PageFactory $resultPageFactory,
        RequestInterface $request,
        Json $json,
        FileInterface $fileInterface,
        Http $http,
        Data $helperData
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->serializer = $json;
        $this->fileInterface = $fileInterface;
        $this->http = $http;
        $this->request = $request;
        $this->helperData = $helperData;
    }

    /**
     * Execute view action
     *
     * @return Http|HttpInterface
     */
    public function execute()
    {
        $response = [
            'code' => 400,
            'message' => __('Invalid Google Drive File ID')
        ];
        try {
            $fileId = $this->request->getParam('file_id');
            $file = $this->fileInterface->getFile($fileId);
            if ($file && in_array($file->getFileExtension(), $this->helperData->getVideoFormat())) {
                $response = [
                    'code' => 200,
                    'message' => 'Get file success',
                    'file_name' => $file->getName(),
                    'file_extension' => $file->getFileExtension()
                ];
            }
        } catch (LocalizedException $e) {
            $response['exception_message'] = $e->getMessage();
        } catch (Exception $e) {
            $response['exception_message'] = $e->getMessage();
        }
        return $this->jsonResponse($response);
    }

    /**
     * Create json response
     *
     * @param string $response
     * @return Http|HttpInterface
     */
    public function jsonResponse($response = '')
    {
        $this->http->setHeader('Content-Type', 'application/json');
        return $this->http->setBody(
            $this->serializer->serialize($response)
        );
    }
}
