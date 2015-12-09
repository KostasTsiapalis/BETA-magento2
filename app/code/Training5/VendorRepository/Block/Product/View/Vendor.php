<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Block\Product\View;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\Product;
use Training5\VendorRepository\Api\VendorRepositoryInterface;

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
     * @var \Training5\VendorRepository\Api\VendorRepositoryInterface
     */
    protected $_vendorRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * Initialize block with context and registry access
     *
     * @param VendorRepositoryInterface $vendorRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        VendorRepositoryInterface $vendorRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Registry $registry,
        Context $context,
        array $data = []
    ) {
        $this->_vendorRepository = $vendorRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
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
     * @return \Training5\VendorRepository\Model\ResourceModel\Vendor\Collection|array
     */
    public function getVendors()
    {
        if (!$this->getProduct()) {
            return [];
        }
        $searchCriteria = $this->_searchCriteriaBuilder
            ->addFilter('product_id', $this->getProduct()->getId())
            ->create();
        return $this->_vendorRepository->getList($searchCriteria)->getItems();
    }
}