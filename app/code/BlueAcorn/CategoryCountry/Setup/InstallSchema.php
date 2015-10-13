<?php
namespace BlueAcorn\CategoryCountry\Setup;

use Magento\Framework\DB\Ddl\Table as DdlTable;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $tableName = $setup->getTable('category_countries');
        $ddlTable = $setup->getConnection()->newTable($tableName);
        $ddlTable->addColumn(
            'category_country_id',
            DdlTable::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Entity ID'
        )->addColumn(
            'category_id',
            DdlTable::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true],
            'Category ID'
        )->addColumn(
            'country',
            DdlTable::TYPE_TEXT,
            32,
            ['nullable' => false, 'default' => 'simple'],
            'Country'
        )->addForeignKey(
            $setup->getFkName('category_countries', 'category_id', 'catalog_category_entity', 'entity_id'),
            'category_id',
            $setup->getTable('catalog_category_entity'),
            'entity_id',
            DdlTable::ACTION_CASCADE
        );

        $setup->getConnection()->createTable($ddlTable);
        $setup->endSetup();
    }
}
