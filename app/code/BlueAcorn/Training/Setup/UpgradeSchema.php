<?php

namespace BlueAcorn\Training\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $connection = $setup->getConnection();

        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $column = [
                'type' => Table::TYPE_SMALLINT,
                'length' => 6,
                'nullable' => true,
                'comment' => 'Type',
                'default' => '0'
            ];
            $connection->addColumn($setup->getTable('blueacorn_training_entity'), 'type', $column);
        }
    }
}
