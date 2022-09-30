<?php
namespace Moonstarcz\Course\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class MoonstarczClass extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'moonstarcz_course_moonstarcz_class';

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
    protected $_eventPrefix = 'moonstarcz_class';

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
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Moonstarcz\Course\Model\ResourceModel\MoonstarczClass');
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
    public function getListCustomerRegistered(){
        $classId = $this->getId();
        $connection = $this->getResource()->getConnection();
        $customerClassTable = $connection->getTableName('moonstarcz_customer_class');
        $select = $connection->select()->from($customerClassTable, 'COUNT(*)')->where('class_id =?', $classId);
        return $connection->fetchOne($select);

    }
}
