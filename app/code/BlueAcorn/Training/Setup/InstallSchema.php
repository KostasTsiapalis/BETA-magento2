<?php

namespace BlueAcorn\Training\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table as DdlTable;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable('blueacorn_training_entity')
            ->addColumn('entity_id', DdlTable::TYPE_INTEGER, null, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
            ), 'Entity ID')
            ->addColumn('title', DdlTable::TYPE_TEXT, 255, array(), 'Title')
            ->setComment('Testing Entity Table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
