<?php
/**
 * @package     Training4\Vendor
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\Vendor\Block\Product\View;

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
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Initialize block with context and registry access
     *
     * @param ObjectManagerInterface $objectManager
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_objectManager = $objectManager;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }
        return $this->_product;
    }

    /**
     * Get vendors for the current product in registry
     *
     * @return \Training4\Vendor\Model\Resource\Vendor\Collection|array
     */
    public function getVendors()
    {
        if (!$this->getProduct()) {
            return array();
        }

        /** @var \Training4\Vendor\Model\Resource\Vendor\Collection $vendorCollection */
        return $this->_objectManager->create('\Training4\Vendor\Model\Vendor')
            ->getCollection()
            ->addFieldToSelect('name')
            ->addProductFilter($this->getProduct()->getId());
    }
}