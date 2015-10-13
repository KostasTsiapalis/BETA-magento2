<?php

namespace BlueAcorn\CategoryCountry\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = array(
            array('category_id' => 11, 'country' => 'France'),
            array('category_id' => 11, 'country' => 'US')
        );
        foreach ($data as $bind) {
            $setup->getConnection()->insertForce($setup->getTable('category_countries'), $bind);
        }
    }
}

