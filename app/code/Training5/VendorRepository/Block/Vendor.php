<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Block;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\Product;

class Vendor extends Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    /**
     * Initialize block with context and registry access
     *
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get products associated with current vendor
     *
     * @return Product
     */
    public function getProducts()
    {
        return $this->getVendor()
            ? $this->getVendor()->getProducts()
            : [];
    }

    /**
     * Get current vendor
     *
     * @return \Training5\VendorRepository\Model\Vendor
     */
    public function getVendor()
    {
        /** @var \Training5\VendorRepository\Model\ResourceModel\Vendor\Collection $vendorCollection */
        return $this->_coreRegistry->registry('vendor');
    }
}
