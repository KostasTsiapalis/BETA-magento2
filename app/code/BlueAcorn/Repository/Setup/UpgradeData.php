<?php
namespace BlueAcorn\Repository\Setup;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $dbVersion = $context->getVersion();
        if (version_compare($dbVersion, '0.1.1', '<')) {
            $tableName = $setup->getTable('ba_repository_example');
            $setup->getConnection()->insertMultiple(
                $tableName,
                [
                    ['name' => 'Foo'],
                    ['name' => 'Bar'],
                    ['name' => 'Baz'],
                    ['name' => 'Qux']
                ]
            );
        }
    }
}