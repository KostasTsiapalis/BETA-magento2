<?php
/**
 * @package     Training4\Vendor
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\Vendor\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $vendorData = [
            ['name' => 'First vendor name'],
            ['name' => 'Second vendor name'],
            ['name' => 'Blue Acorn']
        ];
        foreach($vendorData as $bind) {
            $setup->getConnection()->insertForce($setup->getTable('training4_vendor'), $bind);
        }

        $vendorLinkData = [
            ['vendor_id' => 1, 'product_id' => 66],
            ['vendor_id' => 1, 'product_id' => 130],
            ['vendor_id' => 2, 'product_id' => 130],
            ['vendor_id' => 2, 'product_id' => 210],
            ['vendor_id' => 3, 'product_id' => 66],
            ['vendor_id' => 3, 'product_id' => 210],
            ['vendor_id' => 3, 'product_id' => 226],
        ];
        foreach($vendorLinkData as $bind) {
            $setup->getConnection()->insertForce($setup->getTable('training4_vendor2product'), $bind);
        }
    }
}

