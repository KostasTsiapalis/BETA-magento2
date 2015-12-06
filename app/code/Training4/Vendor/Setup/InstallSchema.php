<?php
/**
 * @package     Training4\Vendor
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\Vendor\Setup;
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
            ->newTable('training4_vendor')
            ->addColumn('vendor_id', DdlTable::TYPE_INTEGER, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
            ], 'Vendor ID')
            ->addColumn('name', DdlTable::TYPE_TEXT, 255, [
                'nullable' => false
            ], 'Name')
            ->setComment('Testing Entity Table');
        $setup->getConnection()->createTable($table);

        $table = $setup->getConnection()
            ->newTable('training4_vendor2product')
            ->addColumn('link_id', DdlTable::TYPE_INTEGER, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
            ], 'Link ID')
            ->addColumn('vendor_id', DdlTable::TYPE_INTEGER, null, [
                'nullable' => false,
                'unsigned' => true
            ], 'Vendor ID')
            ->addColumn('product_id', DdlTable::TYPE_INTEGER, null, [
                'nullable' => false,
                'unsigned' => true
            ], 'Product ID')
            ->addForeignKey(
                $setup->getFkName('training4_vendor2product', 'vendor_id', 'training4_vendor', 'vendor_id'),
                'vendor_id',
                $setup->getTable('training4_vendor'),
                'vendor_id',
                DdlTable::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName('training4_vendor2product', 'product_id', 'catalog_product_entity', 'entity_id'),
                'product_id',
                $setup->getTable('catalog_product_entity'),
                'entity_id',
                DdlTable::ACTION_CASCADE
            );
        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
