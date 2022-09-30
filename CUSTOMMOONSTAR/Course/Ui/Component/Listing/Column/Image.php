<?php
namespace Moonstarcz\Course\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Moonstarcz\Course\Model\MoonstarczTeacher;

class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var MoonstarczTeacher
     */
    protected $teacher;
    protected $_storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param MoonstarczTeacher $teacher
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        MoonstarczTeacher $teacher,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->teacher = $teacher;
        $this->_storeManager = $storeManager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $teacher = new \Magento\Framework\DataObject($item);
                $item[$fieldName . '_src'] = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . "teacher/index/" . $teacher['image'];
                $item[$fieldName . '_orig_src'] = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . "teacher/index/" . $teacher['image'];
                $item[$fieldName . '_orig_src'] = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . "teacher/index/" . $teacher['image'];
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    "moonstarcz/teacher/edit",
                    ['entity_id' => $teacher->getEntity_id()]
                );
                $item[$fieldName . '_alt'] = $teacher['name'];
            }
        }

        return $dataSource;
    }
}
