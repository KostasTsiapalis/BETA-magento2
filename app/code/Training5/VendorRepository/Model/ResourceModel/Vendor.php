<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Model\ResourceModel;

use Training5\VendorRepository\Model\Vendor as VendorModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Vendor extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('training4_vendor', 'vendor_id');
    }

    /**
     * Get product IDs associated with $vendor argument
     * @param VendorModel $vendor
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAssociatedProductIds(VendorModel $vendor)
    {
        $select = $this->getConnection()->select()
            ->from(['link_table' => $this->getTable('training4_vendor2product')], 'product_id')
            ->join(
                ['main_table' => $this->getMainTable()],
                'link_table.vendor_id = main_table.vendor_id',
                []
            )->where('main_table.vendor_id = ?', $vendor->getId());

        return array_map('reset', $this->getConnection()->fetchAll($select));
    }
}
