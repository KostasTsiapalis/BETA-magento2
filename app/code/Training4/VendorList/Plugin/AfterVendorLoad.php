<?php
/**
 * @package     Training4\VendorList
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\VendorList\Plugin;

class AfterVendorLoad
{
    /**
     * @var \Training4\VendorList\Api\Data\VendorExtensionFactory
     */
    protected $_vendorExtensionFactory;

    /**
     * @var \Training4\VendorList\Model\Resource\Vendor
     */
    protected $_vendorResource;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @param \Training4\VendorList\Api\Data\VendorExtensionFactory $vendorExtensionFactory
     * @param \Training4\VendorList\Model\Resource\Vendor $vendorResource
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Training4\VendorList\Api\Data\VendorExtensionFactory $vendorExtensionFactory,
        \Training4\VendorList\Model\Resource\Vendor $vendorResource,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->_vendorExtensionFactory = $vendorExtensionFactory;
        $this->_vendorResource = $vendorResource;
        $this->_productRepository = $productRepository;
    }

    /**
     * Loads associated products onto vendor model
     *
     * @param \Training4\VendorList\Model\Vendor $vendor
     * @return \Training4\VendorList\Model\Vendor
     */
    public function afterLoad(\Training4\VendorList\Model\Vendor $vendor)
    {
        // Get extension object
        $vendorExtension = $vendor->getExtensionAttributes();
        if ($vendorExtension === null) {
            $vendorExtension = $this->_vendorExtensionFactory->create();
        }

        // Gather associated products
        $productIds = $this->_vendorResource->getAssociatedProductIds($vendor);
        $products = [];
        foreach($productIds as $id) {
            $products[$id] = $this->_productRepository->getById($id);
        }

        // Set products on extension object
        $vendorExtension->setProducts($products);
        $vendor->setExtensionAttributes($vendorExtension);
        return $vendor;
    }
}
