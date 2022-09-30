<?php
namespace Moonstarcz\ProductPageDisplay\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('quote_item'),
                'class_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Class ID'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_item'),
                'class_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Class ID'
                ]
            );
        }

        $setup->endSetup();
    }
}
