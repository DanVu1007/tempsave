<?php
namespace Moonstarcz\Course\Ui\Component\Listing\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Moonstarcz\Course\Model\MoonstarczTeacher
     */
    protected $teacher;
    protected $_storeManager;
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Moonstarcz\Course\Model\MoonstarczTeacher $teacher
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Moonstarcz\Course\Model\MoonstarczTeacher $teacher,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
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
     */
    public function prepareDataSource(array $dataSource)
    {

        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $teacher = new \Magento\Framework\DataObject($item);
                $item[$fieldName . '_src'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."teacher/index/".$teacher['image'];
                $item[$fieldName . '_orig_src'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."teacher/index/".$teacher['image'];
                $item[$fieldName . '_orig_src'] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."teacher/index/".$teacher['image'];
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl("moonstarcz/teacher/edit",
                    ['entity_id' => $teacher->getEntity_id()]
                );
                $item[$fieldName . '_alt'] = $teacher['name'];
            }
        }

        return $dataSource;
    }
}
